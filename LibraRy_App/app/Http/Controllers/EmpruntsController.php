<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Emprunt;
use App\Models\Exemplaire;
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
                        $q->where('name', 'like', "%{$search}%")
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
            'total'     => (clone $query)->count(),
            'en_cours'  => (clone $query)->where('date_retour_prevue', '>=', now())->count(),
            'en_retard' => (clone $query)->where('date_retour_prevue', '<', now())->count(),
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
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

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
    private function isRented($id){
        $isRented = Emprunt::where('user_id', Auth::user()->id)->where('exemplaire_id', $id)->first();

        return $isRented ;
    }
//    **************************************************************************************************************************************
    /**
     * Display the specified resource.
     */
    public function show(Request $request)
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
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

//    **************************************************************************************************************************************
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

//    **************************************************************************************************************************************
/**
 * Remove the specified resource from storage.
 */
    public function destroy(string $id)
    {
        //
    }
//    **************************************************************************************************************************************
// pour l'admin +++++++++++++++++++++++++++++++++++++++++++++
    public function valider(string $id)
    {
        $emprunt = Emprunt::where('id', $id)
            ->where('status', 'en attente')
            ->firstOrFail();

        $emprunt->update([
            'status'             => 'validé',
            'date_emprunt'       => now(),
            'date_retour_prevue' => now()->addWeeks(3),
        ]);

        $exemplaireRented = Exemplaire::find($emprunt->exemplaire->id);

        // dd($exemplaireRented);
        $exemplaireRented->disponible = 0 ;
        $exemplaireRented->save();

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
public function annuler(string $id){
    $maDemande = Emprunt::find($id);

    $maDemande->delete();
    return back()->with('success', 'Vous étes annuler Votre demande d\'emprunt de '.$maDemande->exemplaire->book->title);
}
}
