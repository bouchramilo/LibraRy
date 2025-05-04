<?php
namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{
    // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    // Auth :
    // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    // **********************************************************************************************************************************
    public function showLogin()
    {
        return view("Auth.login");
    }

    // **********************************************************************************************************************************
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            if (Auth::user()->role === "Client") {
                return redirect()->intended('/client/dashboard');
            } else {
                return redirect()->intended('/admin/dashboard');
            }
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    // **********************************************************************************************************************************
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    // *******************************************************************************************************************************
    // register function
    public function showRegister()
    {
        return view("Auth.register");
    }

    // *******************************************************************************************************************************
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'first_name'  => ['required', 'string', 'max:255'],
            'last_name'   => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password'    => ['required', 'confirmed', Rules\Password::defaults()],
            'photo'       => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'address'     => ['required', 'string', 'max:255'],
            'telephone'   => ['required', 'string'],
            'date_birth'  => ['required', 'date', 'before:-18 years'],
            'city'        => ['required', 'string', 'max:255'],
            'code_postal' => ['required', 'digits:5'],
            // 'role' => ['required'],
        ]);

        $role = User::count() === 0 ? 'Bibliothécaire' : 'Client';

        try {
            $photoPath = $request->file('photo')->store('profiles', 'public');

            $user = User::create([
                'first_name'  => $validatedData['first_name'],
                'last_name'   => $validatedData['last_name'],
                'email'       => $validatedData['email'],
                'password'    => Hash::make($validatedData['password']),
                'photo'       => $photoPath,
                'address'     => $validatedData['address'],
                'telephone'   => $validatedData['telephone'],
                'date_birth'  => $validatedData['date_birth'],
                'city'        => $validatedData['city'],
                'code_postal' => $validatedData['code_postal'],
                'role'        => $role,

            ]);

            event(new Registered($user));

            Auth::login($user);
            if (Auth::user()->role === "Client") {
                return redirect()->route('client.dashboard')
                    ->with('success', 'Inscription réussie! Vous pouvez maintenant vous connecter.');
            } else {
                return redirect()->route('librarian.dashboard')
                    ->with('success', 'Inscription réussie! Vous pouvez maintenant vous connecter.');
            }

        } catch (\Exception $e) {
            dd($e);
            return back()
                ->withInput()
                ->withErrors(['error' => 'Une erreur est survenue lors de l\'inscription: ' . $e->getMessage()]);
        }
    }

    // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
// profile
    // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    public function showProfile()
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté pour accéder à votre profil.');
        }

        return view('profile', compact('user'));
    }

    // **********************************************************************************************************************************
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'first_name'  => ['required', 'string', 'max:255'],
            'last_name'   => ['required', 'string', 'max:255'],
            'email'       => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'photo'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'address'     => ['required', 'string', 'max:255'],
            'date_birth'  => ['required', 'date', 'before:-18 years'],
            'city'        => ['required', 'string', 'max:255'],
            'code_postal' => ['required', 'digits:5'],
        ]);

        try {
            if ($request->hasFile('photo')) {
                if ($user->photo) {
                    Storage::disk('public')->delete($user->photo);
                }
                $photoPath              = $request->file('photo')->store('profiles', 'public');
                $validatedData['photo'] = $photoPath;
            }

            $user->update($validatedData);

            return back()->with('success', 'Profil mis à jour avec succès!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Une erreur est survenue lors de la mise à jour du profil: ' . $e->getMessage()]);
        }
    }

    // **********************************************************************************************************************************
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'old_password' => ['required', 'string', 'current_password'],
            'new_password' => [
                'required',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
                'confirmed',
            ],
        ]);

        try {
            $user->update([
                'password' => Hash::make($validatedData['new_password']),
            ]);

            return back()->with('success', 'Mot de passe mis à jour avec succès!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Une erreur est survenue lors de la mise à jour du mot de passe: ' . $e->getMessage()]);
        }
    }

    // **********************************************************************************************************************************
    public function deleteAccount(Request $request)
    {
        $validatedData = $request->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        try {
            $user = $request->user();

            Auth::logout();

            $user->delete();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('home')
                ->with('success', 'Votre compte a été supprimé avec succès.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la suppression du compte : ' . $e->getMessage());
        }
    }
    // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    // *******************************************************************************************************************************
    // afficher les users pour le librarian
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
// supprimer un user (librarian)
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
// modifier status pour les users (librarian)
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
