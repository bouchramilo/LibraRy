<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Emprunt;
use App\Models\Exemplaire;
use App\Notifications\NotificationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmpruntsController extends Controller
{
//    **************************************************************************************************************************************
    /**
     * Display a listing of the resource.
     */
    // pour admin +++++++++++++++++++++++++++++++++++++++++++++
    public function index(Request $request)
    {
        $query = Emprunt::with(['exemplaire.book', 'user'])
            ->latest('date_emprunt');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('exemplaire.book', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%");
                })
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('exemplaire', function ($q) use ($search) {
                        $q->where('code_serial_exemplaire', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'retard') {
                $query->whereNull('date_retour_effectif')
                    ->where('date_retour_prevue', '<', now());
            } else {
                $query->where('status', $request->status);
            }
        } else {
            $query->whereNull('date_retour_effectif');
        }

        $stats = [
            'en_attente'        => (clone $query)->where('status', '=', "en attente")->count(),
            'en_cours'          => (clone $query)->where('status', '=', "validé")->whereNull('date_retour_effectif')->count(),
            'retard_exemplaire' => Emprunt::where('status', 'retard')->whereNull('date_retour_effectif')->count(),
        ];

        $emprunts = $query->paginate(10);

        return view('Librarian.emprunts', [
            'emprunts'      => $emprunts,
            'stats'         => $stats,
            'search'        => $request->search,
            'status'        => $request->status,
            'statusOptions' => [
                'en_cours'  => 'En cours',
                'en_retard' => 'En retard',
                'retourne'  => 'Retourné',
            ],
        ]);
    }

//    **************************************************************************************************************************************
//    **************************************************************************************************************************************
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'exemplaire_id' => 'required|exists:exemplaires,id',
        ]);

        if (Auth::user()->status === 'Suspendu') {
            return redirect()->route('client.catalogue')
                ->with('error', 'Vous étes "Suspendu", essayez plus tard !');

        }

        $exemplaireDejaEmprunte = Emprunt::where('exemplaire_id', $validated['exemplaire_id'])
            ->whereNull('date_retour_effectif')
            ->exists();

        if ($exemplaireDejaEmprunte) {
            return redirect()->route('client.catalogue')
                ->with('error', 'Ce livre est déjà emprunté par un autre utilisateur!');
        }

        $utilisateurDejaEmprunte = Emprunt::where('user_id', Auth::id())
            ->where('exemplaire_id', $validated['exemplaire_id'])
            ->whereNull('date_retour_effectif')
            ->exists();

        if ($utilisateurDejaEmprunte) {
            return redirect()->route('client.catalogue')
                ->with('error', 'Vous avez déjà emprunté cet exemplaire!');
        }

        $dateRetourPrevue = now()->addWeeks(3);

        Emprunt::create([
            'user_id'       => Auth::id(),
            'exemplaire_id' => $validated['exemplaire_id'],
            'date_emprunt'  => now(),
        ]);

        return redirect()->route('client.catalogue')
            ->with('success', 'Emprunt créé avec succès! Date de retour prévue: ' . $dateRetourPrevue->format('d/m/Y'));
    }

    //    **************************************************************************************************************************************
    private function isRented($id)
    {
        $isRented = Emprunt::where('user_id', Auth::user()->id)->where('exemplaire_id', $id)->first();

        return $isRented;
    }
//    **************************************************************************************************************************************
    /**
     * Display the specified resource.
     */
    public function showMyRent(Request $request)
    {
        $query = Emprunt::with(['exemplaire.book'])
            ->where('user_id', Auth::id())
            ->whereNull('date_retour_effectif');

        if ($request->has('search') && $request->search) {
            $query->whereHas('exemplaire.book', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('author', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $mesEmprunts = $query->get();

        return view('Client.mesEmprunts', compact('mesEmprunts'));
    }

//    **************************************************************************************************************************************
// pour l'admin +++++++++++++++++++++++++++++++++++++++++++++
    public function valider(string $id)
    {
        $emprunt = Emprunt::with(['exemplaire.book', 'user'])
            ->where('id', $id)
            ->where('status', 'en attente')
            ->firstOrFail();

        $emprunt->update([
            'status'             => 'validé',
            'date_emprunt'       => now(),
            'date_retour_prevue' => now()->addWeeks(3),
        ]);

        $emprunt->exemplaire->disponible = 0;
        $emprunt->exemplaire->save();

        $bookTitle  = $emprunt->exemplaire->book->title;
        $returnDate = $emprunt->date_retour_prevue->format('d/m/Y');

        $message = "Votre demande d'emprunt pour le livre '{$bookTitle}' a été validée. ";
        $message .= "Vous pouvez venir le retirer à la bibliothèque jusqu'au {$returnDate}.";

        $emprunt->user->notify(new NotificationEmail(
            message: $message,
            bookTitle: $bookTitle,
            actionUrl: route('client.emprunt.show', $emprunt->id),
            actionText: 'Voir mon emprunt'
        ));

        return redirect()->route('librarian.emprunts.index')
            ->with('success', 'Emprunt validé avec succès !');
    }
//    **************************************************************************************************************************************
// pour l'admin +++++++++++++++++++++++++++++++++++++++++++++
    public function details($id)
    {
        $emprunt = Emprunt::with(['exemplaire.book', 'user'])->findOrFail($id);
        return view('Librarian.show-emprunt', compact('emprunt'));
    }

//    **************************************************************************************************************************************
    public function annuler(string $id)
    {
        $maDemande = Emprunt::find($id);

        $maDemande->delete();
        return back()->with('success', 'Vous étes annuler Votre demande d\'emprunt de ' . $maDemande->exemplaire->book->title);
    }

//    **************************************************************************************************************************************
    public function returnExemplaire(string $id)
    {
        $emprunt                       = Emprunt::find($id);
        $emprunt->date_retour_effectif = now();
        $emprunt->save();

        $exemplaire             = Exemplaire::find($emprunt->exemplaire_id);
        $exemplaire->disponible = 1;
        $exemplaire->save();

        return back()->with('success', 'Vous avez retourner le livre avec success.');
    }

//    **************************************************************************************************************************************
// Les reutours pour l'admin ++++++++++
    public function retours(Request $request)
    {
        $query = Emprunt::with(['exemplaire.book', 'user'])
            ->whereNotNull('date_retour_effectif')
            ->latest('date_retour_effectif');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('exemplaire.book', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%");
                })
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('exemplaire', function ($q) use ($search) {
                        $q->where('code_serial_exemplaire', 'like', "%{$search}%");
                    });
            });
        }

        $stats = [
            'en_attente'        => (clone $query)->where('status', '=', "en attente")->count(),
            'en_cours'          => (clone $query)->where('status', '=', "validé")->whereNull('date_retour_effectif')->count(),
            'retard_exemplaire' => Emprunt::where('status', 'retard')->whereNull('date_retour_effectif')->count(),
        ];

        $emprunts = $query->paginate(10);

        return view('Librarian.retours', [
            'emprunts' => $emprunts,
            'stats'    => $stats,
            'search'   => $request->search,
        ]);
    }

}
