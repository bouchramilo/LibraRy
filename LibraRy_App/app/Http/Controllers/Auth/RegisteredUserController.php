<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function index()
    {
        return view("Auth.register");
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name'  => ['required', 'string', 'max:255'],
            'last_name'   => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password'    => ['required', 'confirmed', Rules\Password::defaults()],
            'photo'       => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'address'     => ['required', 'string', 'max:255'],
            'telephone'   => ['required', 'string'],
            'date_birth' => ['required', 'date', 'before:-18 years'],
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
                'telephone'     => $validatedData['telephone'],
                'date_birth'  => $validatedData['date_birth'],
                'city'        => $validatedData['city'],
                'code_postal' => $validatedData['code_postal'],
                'role' => $role,

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
}
