<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class NewPasswordController extends Controller
{
    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $this->validateResetPasswordRequest($request);
        $credentials = $request->only(['email', 'password', 'password_confirmation', 'token']);

        $status = $this->resetPassword($credentials);
        $this->throwErrorIfNotReset($status);

        return response()->json(['status' => __($status)]);
    }

    /**
     * @param array $credentials
     * @return mixed
     */
    private function resetPassword(array $credentials): mixed
    {
        $password = $credentials->password;

        return Password::reset(
            $credentials,
            function ($user) use ($password) {
                $this->updateUserPassword($user, $password);
                event(new PasswordReset($user));
            }
        );
    }

    /**
     * @param Request $request
     * @return void
     */
    private function validateResetPasswordRequest(Request $request): void
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults()
            ],
        ]);
    }

    /**
     * @param $user
     * @param $password
     * @return void
     */
    function updateUserPassword($user, $password): void
    {
        $user->forceFill([
            'password' => Hash::make($password),
            'remember_token' => Str::random(60),
        ])->save();
    }

    /**
     * @param mixed $status
     * @return void
     * @throws ValidationException
     */
    public function throwErrorIfNotReset(mixed $status): void
    {
        if ($status != Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }
    }
}
