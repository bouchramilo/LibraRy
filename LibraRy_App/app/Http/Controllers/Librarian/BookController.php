<?php
namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
//    **********************************************************************************************************************************************
    /**
     * Display a listing of the resource.
      */
    public function index(Request $request)
    {
        $query = Book::with('categories');

        if ($request->has('category_id') && $request->category_id) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                  ->orWhere('author', 'like', '%'.$request->search.'%')
                  ->orWhere('isbn', 'like', '%'.$request->search.'%')
                  ->orWhere('resume', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->has('language') && $request->language) {
            $query->where('language', $request->language);
        }

        $sortField = $request->get('sort', 'title');
        $sortDirection = $request->get('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        $books = $query->paginate(9);

        $categories = Category::pluck('category', 'id')->prepend('Toutes les catégories', '');
        $languages = Book::select('language')->distinct()->pluck('language', 'language');

        return view('librarian.books', compact('books', 'categories', 'languages'));
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
            // 'prix_vente'    => 'required|numeric|min:0',
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
        $book = Book::find($id);
        return view('Librarian.showBookDetails', compact("book"));
    }

//    **********************************************************************************************************************************************
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book       = Book::findOrFail($id);
        $categories = Category::pluck('category', 'id');
        return view('Librarian.updateBook', compact('categories', 'book'));
    }

//    **********************************************************************************************************************************************
    /**
     * Update the specified resource in storage.
     */
 // Dans BookController.php
public function update(Request $request, Book $book)
{
    $validatedData = $request->validate([
        'title'         => 'required|string|max:255',
        'author'        => 'required|string|max:255',
        'resume'        => 'required|string',
        'photo'         => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        'nbr_pages'     => 'required|integer|min:1',
        'date_edition'  => 'required|date|before_or_equal:today',
        'isbn'          => ['required', 'string', 'max:20', Rule::unique('books')->ignore($book->id)],
        'language'      => 'required|string|max:50',
        'prix_emprunte' => 'required|numeric|min:0',
        // 'prix_vente'    => 'required|numeric|min:0|gte:prix_emprunte',
        'categories'    => 'nullable|array',
        'categories.*'  => 'exists:categories,id',
    ]);

    try {
        DB::beginTransaction();

        if ($request->hasFile('photo')) {
            if ($book->photo && Storage::disk('public')->exists($book->photo)) {
                Storage::disk('public')->delete($book->photo);
            }

            $photoPath = $request->file('photo')->store('book_covers', 'public');
            $validatedData['photo'] = $photoPath;
        }

        $book->update($validatedData);

        $book->categories()->sync($request->input('categories', []));

        DB::commit();

        return redirect()
            ->route('librarian.books.index')
            ->with('success', 'Le livre "'.$book->title.'" a été mis à jour avec succès !');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Erreur lors de la mise à jour du livre : '.$e->getMessage());

        return back()
            ->withInput()
            ->with('error', 'Une erreur est survenue lors de la mise à jour du livre.');
    }
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
