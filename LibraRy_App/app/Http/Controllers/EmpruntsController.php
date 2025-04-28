<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Emprunt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmpruntsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'exemplaire_id' => 'required|exists:exemplaires,id',
        ]);

        // Vérifier si l'exemplaire est déjà emprunté
        $existingLoan = Emprunt::where('exemplaire_id', $validated['exemplaire_id'])
            ->whereNull('date_retour_effectif')
            ->exists();

        if ($existingLoan) {
            return redirect()->route('client.catalogue')
                ->with('error', 'Ce livre est déjà emprunté!');
        }

        Emprunt::create([
            'user_id'       => Auth::id(),
            'exemplaire_id' => $validated['exemplaire_id'],
            'date_emprunt'  => now(),
        ]);

        return redirect()->route('client.catalogue')
            ->with('success', 'Emprunt créé avec succès!');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $mesEmprunts = Emprunt::with('exemplaire.book')
            ->where('user_id', Auth::id())
            ->whereNull('date_retour_effectif')
            ->get();

        return view('Client.mesEmprunts', compact('mesEmprunts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
