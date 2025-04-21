<?php
namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    // *******************************************************************************************************************************
    public function index()
    {
        $categories = Category::paginate(9);
        return view('Librarian.categories', ["categories" => $categories]);
    }

    // *******************************************************************************************************************************
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category' => ['required', 'string', 'max:255'],
        ]);

        try {

            $category = Category::create([
                'category' => $validatedData['category'],
            ]);

            return redirect()->route('manage.categories.index')
                ->with('success', 'Vous avez ajouter un catégorie avec success');

        } catch (\Exception $e) {
            dd($e);
            return back()
                ->withInput()
                ->withErrors(['error' => 'Une erreur est survenue lors de l\'ajout d\'un catégorie: ' . $e->getMessage()]);
        }

    }

    // *******************************************************************************************************************************
    public function destroy(string $category_id)
    {
        $category = Category::findOrFail($category_id);
        $category->delete();
        return back()->with("success", "Vous avez supprimer le catégorie avec success.");
    }

    // *******************************************************************************************************************************
    public function update(Request $request, string $category_id){
        $validatedData = $request->validate([
            'category' => ['required', 'string', 'max:255'],
        ]);

        try {

            $category = Category::findOrFail($category_id);

            $category->update([
                'category' => $validatedData['category'],
            ]);

            return redirect()->route('manage.categories.index')
                ->with('success', 'Vous avez modifier un catégorie avec success');

        } catch (\Exception $e) {
            // dd($e);
            return back()
                ->withInput()
                ->withErrors(['error' => 'Une erreur est survenue lors de la modification d\'un catégorie: ' . $e->getMessage()]);
        }
    }
}
