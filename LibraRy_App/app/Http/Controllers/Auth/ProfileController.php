<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    // **********************************************************************************************************************************
    public function index()
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté pour accéder à votre profil.');
        }

        return view('profile', compact('user'));
    }

    // **********************************************************************************************************************************
    public function update(Request $request)
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
}
