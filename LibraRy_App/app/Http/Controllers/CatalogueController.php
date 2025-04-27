<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Exemplaire;
use Illuminate\Http\Request;

class CatalogueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Exemplaire::with('book');

        // Filtre par titre de livre
        if ($request->has('book_id') && $request->book_id) {
            $query->where('book_id', $request->book_id);
        }

        // Filtre par recherche
        if ($request->has('search') && $request->search) {
            $query->whereHas('book', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('author', 'like', '%' . $request->search . '%')
                    ->orWhere('code_serial_exemplaire', 'like', '%' . $request->search . '%');
            });
        }

        $exemplaires = $query->paginate(10);
        $options     = Book::pluck('title', 'id')->prepend('Tous les livres', '');
        $categories =  Category::pluck('category', 'id');

        return view('Client.catalogue',compact('exemplaires', 'options', 'categories'));
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
        //
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
