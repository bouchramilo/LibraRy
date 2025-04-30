<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Emprunt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ClientDashboardController extends Controller
{
    // ******************************************************************************************************************************************
    public function index()
    {
        $user = Auth::user();

        //
        $book_rented = Emprunt::where('user_id', $user->id)
            ->whereIn('status', ['validé', 'retard'])
            ->whereNull('date_retour_effectif')
            ->count();

        //
        // $overdue_books = Emprunt::where('user_id', $user->id)
        //     ->where('status', 'retard')
        //     ->whereNull('date_retour_effectif')
        //     ->count();


        $overdue_books = Emprunt::with(['exemplaire.book'])
        ->where('user_id', $user->id)
        ->where('status', 'retard')
        ->whereNull('date_retour_effectif')
        ->where('date_retour_prevue', '<', now())
        ->orderBy('date_retour_prevue', 'asc')
        ->get();

        //
        $next_return = Emprunt::where('user_id', $user->id)
            ->where('status', 'validé')
            ->whereNull('date_retour_effectif')
            ->where('date_retour_prevue', '>=', Carbon::now())
            ->orderBy('date_retour_prevue', 'asc')
            ->first();

        //
        //
        $recent_activities = Emprunt::where('user_id', $user->id)
        ->with(['exemplaire.book'])
        ->orderBy('date_emprunt', 'desc')
        ->limit(3)
        ->get()
        ->map(function ($emprunt) {
            $emprunt->date_emprunt = Carbon::parse($emprunt->date_emprunt);
            $emprunt->date_retour_effectif = $emprunt->date_retour_effectif
                ? Carbon::parse($emprunt->date_retour_effectif)
                : null;
            return $emprunt;
        });

        // dd($overdue_books);

        return view('Client.dashboard-client', [
            'book_rented'       => $book_rented,
            'overdue_books'     => $overdue_books,
            'next_return_date'  => $next_return ? Carbon::parse($next_return->date_retour_prevue) : 'Aucun retour prévu',
            'recent_activities' => $recent_activities,
        ]);
    }

    // ******************************************************************************************************************************************

    // ******************************************************************************************************************************************

}
