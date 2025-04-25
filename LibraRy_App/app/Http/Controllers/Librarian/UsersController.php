<?php
namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    // *******************************************************************************************************************************
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%$search%")
                        ->orWhere('last_name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                });
            })
            ->when($request->role, fn($q, $role) => $q->where('role', $role))
            ->when($request->status, fn($q, $status) => $q->where('status', $status))
            ->paginate(10);

        return view('Librarian.users', compact('users'));
    }
    // *******************************************************************************************************************************

    // *******************************************************************************************************************************
    public function destroy(string $user_id)
    {
        $user = User::find($user_id);

        if (! $user) {
            return back()->with("error", "Vous avez essayé de supprimer un utilisateur non trouvé");
        }

        $user->delete();
        return back()->with("success", "Vous avez supprimé le client avec succès.");
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
