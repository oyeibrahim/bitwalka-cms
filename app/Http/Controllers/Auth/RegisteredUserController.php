<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utilities;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        $referrer = null;

        if ($request->has('ref')) {
            $referrer = $request->input('ref');
        }

        return view('auth.register', ['ref' => $referrer, 'page_name' => 'register', 'page_title' => 'User Registration']);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'firstname' => ['required', 'string', 'max:100'],
            'lastname' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:100', 'unique:' . User::class],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        //-----------------Referral-----------------//
        $referrer = $request->referral_id;

        if ($request->referral_id) {
            if (DB::table('users')->where('user_id', $request->referral_id)->doesntExist()) {
                $referrer = null;
            }
        }
        //-----------------+++++++++-----------------//


        //-----------------User ID-----------------//
        $util = new Utilities();

        $userid = Str::of($util->random_string('alnum', 7))->upper();

        while (DB::table('users')->where('user_id', $userid)->exists()) {
            $userid = Str::of($util->random_string('alnum', 6))->upper();
        }
        //-----------------+++++++++-----------------//


        //-----------------User Role-----------------//
        $lowest_role = DB::table('roles')->orderBy('number', 'desc')->value('name');
        //-----------------+++++++++-----------------//

        $user = User::create([
            'user_id' => $userid,
            'role' => $lowest_role,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'referral_id' => $referrer,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(app()->getLocale().RouteServiceProvider::HOME);
    }
}
