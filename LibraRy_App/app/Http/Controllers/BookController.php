<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
//    **********************************************************************************************************************************************
    /**
     * Display a listing of the resource.
     */public function index()
    {
        $books = Book::with(['categories' => function ($query) {
            $query->select('categories.id', 'categories.category');
        }])->get();

        return view('Librarian.books', compact('books'));
    }

//    **********************************************************************************************************************************************
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::pluck('category', 'id');
        return view('Librarian.addBook', compact('categories'));
    }

//    **********************************************************************************************************************************************
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'title'         => 'required|string|max:255',
            'author'        => 'required|string|max:255',
            'resume'        => 'required|string',
            'photo'         => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nbr_pages'     => 'required|integer|min:1',
            'date_edition'  => 'required|date',
            'isbn'          => 'required|string|unique:books,isbn|max:20',
            'language'      => 'required|string|max:50',
            'prix_emprunte' => 'required|numeric|min:0',
            'prix_vente'    => 'required|numeric|min:0',
            "categories"    => "nullable|array",
            "categories.*"  => "exists:categories,id",
        ]);

        if ($request->hasFile('photo')) {
            $photoPath              = $request->file('photo')->store('book_covers', 'public');
            $validatedData['photo'] = $photoPath;
        }

        $book = Book::create($validatedData);

        if ($request->has('categories')) {
            $book->categories()->attach($request->categories);
        }
        return redirect()->route('librarian.books.index')
            ->with('success', 'Livre ajouté avec succès !');
    }
//    **********************************************************************************************************************************************
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('Librarian.showBookDetails');
    }

//    **********************************************************************************************************************************************
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('Librarian.updateBook');
    }

//    **********************************************************************************************************************************************
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

//    **********************************************************************************************************************************************
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->back()->with('success', 'Livre supprimé avec succès');
    }
}
