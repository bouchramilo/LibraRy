<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Emprunt;
use App\Models\Exemplaire;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LibrarianDashboardController extends Controller
{
    public function index()
    {
        $nbr_books       = Book::count();
        $nbr_exemplaires = Exemplaire::count();
        $pending_borrows = Emprunt::where('status', 'en attente')->count();
        $total_users     = User::where('role', '=', "Client")->count();

        // Récupération des données pour le graphique
        $categoriesData = DB::table('categories')
            ->select(
                'categories.category as category_name',
                DB::raw('COUNT(book_category.book_id) as book_count')
            )
            ->leftJoin('book_category', 'categories.id', '=', 'book_category.category_id')
            ->groupBy('categories.category')
            ->orderBy('book_count', 'desc')
            ->get();

            // dd($categoriesData);

        $exmp_non_dispo = Exemplaire::where('disponible', '=', 0)->count();
        return view('Librarian.dashboard',
            [
                'nbr_books' => $nbr_books,
                'nbr_exemplaires' => $nbr_exemplaires,
                'exmp_non_dispo' => $exmp_non_dispo,
                'pending_borrows' => $pending_borrows,
                'total_users' => $total_users,
                'categoriesData' => $categoriesData,

            ]);
    }
}
