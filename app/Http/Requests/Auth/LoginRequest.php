<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // Auth::user() doesnt exist here, to get user you will fetch from database
        // To check any other login requirement here you will just return the error and 
        // you don't need to log the user out since user hasn't been logged in

        // Auth::attempt will log in the user and user data will be avilable in Auth::user()
        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // To check any other login requirement here you must log the user out
        // if the check fail since the user is already logged in
        if (Auth::user()->status == 0) {
            RateLimiter::hit($this->throttleKey());

            Auth::logout();
            throw ValidationException::withMessages([
                'email' => trans('auth.account_deactivated'),
            ]);
        }

        if (Auth::user()->status == 2) {
            RateLimiter::hit($this->throttleKey());
            
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => trans('auth.account_pending'),
            ]);
        }
        
        if (Auth::user()->status == 3) {
            RateLimiter::hit($this->throttleKey());
            
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => trans('auth.account_suspended'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')).'|'.$this->ip());
    }
}
