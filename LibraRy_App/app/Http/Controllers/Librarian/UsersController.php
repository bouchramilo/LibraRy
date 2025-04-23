<?php
namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    // *******************************************************************************************************************************
    // public function index()
    // {
    //     $users = User::where("id", "!=", Auth::id())->paginate(10);
    //     return view('Librarian.users', ['users' => $users]);
    // }
    // Dans UserController.php

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
    // Dans UserController.php
    public function filter(Request $request)
    {
        $users = User::query()
            ->when($request->search, fn($q, $search) => $q->where(function ($query) use ($search) {
                $query->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            }))
            ->when($request->role, fn($q, $role) => $q->where('role', $role))
            ->when($request->status, fn($q, $status) => $q->where('status', $status))
            ->paginate(10);

        return response()->json([
            'users'      => $users,
            'pagination' => $users->links()->toHtml(),
        ]);
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
