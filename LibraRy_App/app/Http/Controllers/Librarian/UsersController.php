<?php
namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    // *******************************************************************************************************************************
    public function index()
    {
        $users = User::where("id", "!=", Auth::id())->paginate(10);
        return view('Librarian.users', ['users' => $users]);
    }
    // *******************************************************************************************************************************
    public function destroy(string $user_id)
    {
        $user = User::findOrFail($user_id);
        $user->delete();
        return back()->with("success", "Vous avez supprimer le client avec success.");
    }

    // *******************************************************************************************************************************
    public function updateStatus(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);

        $user->status = $user->status === 'Active' ? 'Suspendu' : 'Active';
        $user->save();

        return back()->with("Success", "Statut utilisateur mis à jour");
    }

    // *******************************************************************************************************************************
//
    // *******************************************************************************************************************************
//
    // *******************************************************************************************************************************
}
