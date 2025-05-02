<?php
namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Exemplaire;
use Illuminate\Http\Request;

class ExemplaireController extends Controller
{
// *******************************************************************************************************************************
    /**
     * Generate books options for select dropdown
     */
    protected function getBooksOptions()
    {
        return Book::orderBy('title')
            ->get()
            ->mapWithKeys(fn($book) => [
                $book->id => "{$book->title} - ({$book->author})",
            ])
            ->toArray();
    }

// *******************************************************************************************************************************
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

        return view('librarian.exemplaires', compact('exemplaires', 'options'));
    }

// *******************************************************************************************************************************
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $options = $this->getBooksOptions();
        return view('Librarian.addExemplaire', compact('options'));
    }

// *******************************************************************************************************************************
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'book_id'                => 'required|exists:books,id',
            'code_serial_exemplaire' => 'required|string|max:50|unique:exemplaires',
            'etat'                   => 'required|in:neuf,bon,usé,endommagé',
            'rayon'                  => 'required|string|max:30',
            'etagere'                => 'nullable|string|max:30',
        ]);

        Exemplaire::create($validatedData);

        return redirect()
            ->route('librarian.exemplaires.index')
            ->with('success', 'Exemplaire ajouté avec succès !');
    }

// *******************************************************************************************************************************
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $exemplaire = Exemplaire::with('book')->findOrFail($id);
        $options    = $this->getBooksOptions();

        return view('Librarian.editExemplaire', compact('options', 'exemplaire'));
    }

// *******************************************************************************************************************************
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'book_id'                => 'required|exists:books,id',
            'code_serial_exemplaire' => 'required|string|max:50|unique:exemplaires,code_serial_exemplaire,' . $id,
            'etat'                   => 'required|in:neuf,bon,usé,endommagé',
            'rayon'                  => 'required|string|max:30',
            'etagere'                => 'required|string|max:30',
        ]);

        $exemplaire = Exemplaire::findOrFail($id);
        $exemplaire->update($validatedData);

        return redirect()
            ->route('librarian.exemplaires.index')
            ->with('success', 'L\'exemplaire a été modifié avec succès.');
    }

// *******************************************************************************************************************************
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $exemplaire = Exemplaire::findOrFail($id);
        $exemplaire->delete();

        return back()
            ->with('success', 'Exemplaire supprimé avec succès');
    }
    // *******************************************************************************************************************************
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $exemplaire = Exemplaire::find($id);
        // dd($exemplaire);
        return view('Librarian.detailsExemplaire', compact("exemplaire"));
    }

    // *******************************************************************************************************************************
    public function showClient(string $id)
    {
        $exemplaire = Exemplaire::find($id);
        return view('Client.details-book', compact("exemplaire"));
    }

    // *******************************************************************************************************************************

    public function afficherCatalogue(Request $request)
    {
        $query = Exemplaire::with(['book', 'book.categories']);

        // catégorie
        if ($request->has('category_id') && $request->category_id) {
            $query->whereHas('book.categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }

        // titre de livre
        if ($request->has('book_id') && $request->book_id) {
            $query->where('book_id', $request->book_id);
        }

        // Input recherche
        if ($request->has('search') && $request->search) {
            $query->whereHas('book', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('author', 'like', '%' . $request->search . '%')
                    ->orWhere('code_serial_exemplaire', 'like', '%' . $request->search . '%');
            });
        }

        $exemplaires = $query->paginate(4);
        $options     = Book::pluck('title', 'id')->prepend('Tous les livres', '');
        $categories  = Category::pluck('category', 'id')->prepend('Toutes les catégories', '');

        return view('Client.catalogue', compact('exemplaires', 'options', 'categories'));
    }
}
