<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Exemplaire;
use Illuminate\Http\Request;

class ExemplaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exemplaires = Exemplaire::all();
        return view('Librarian.exemplaires', compact("exemplaires"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $livres = Book::orderBy('title')->get(['id', 'title', 'author']);

        $options = [];
        foreach (Book::orderBy('title')->get() as $livre) {
            $options[$livre->id] = "{$livre->title} - ({$livre->author})";
        }
        return view('Librarian.addExemplaire', compact('options'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'book_id' => 'required|exists:books,id',
            'code_serial_exemplaire' => [
                'required',
                'string',
                'max:50',
                'unique:exemplaires,code_serial_exemplaire'
            ],
            'etat' => 'required|in:neuf,bon,usé,endommagé',
            'rayon' => 'required|string|max:30',
            'etagere' => 'nullable|string|max:30',
        ]);

        Exemplaire::create($validatedData);

        return redirect()->route('librarian.exemplaires.index')
            ->with('success', 'Exemplaire ajouté avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
