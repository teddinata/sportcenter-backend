<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Rules\Password;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['nullable', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'confirmed', new Password],
                'password_confirmation' => ['required', 'string', 'min:8'],
            ]);

            // Check email existence
            if (User::where('email', $request->email)->exists()) {
                throw ValidationException::withMessages([
                    'email' => ['Email is already taken. Please choose another.']
                ]);
            }

            // Creating or getting a new user
            $user = User::firstOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->name,
                    'username' => $request->username,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password),
                ]
            );

            // Creating a token for the newly created user
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            // Returning user and token data to the client
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'User registered successfully');

        } catch (ValidationException $e) {
            // Handling validation errors
            $errors = $e->errors();
            return ResponseFormatter::error([
                'message' => 'Validation failed',
                'errors' => $errors,
            ], 'Authentication Failed', 422);

        } catch (\Exception $e) {
            // Handling other exceptions
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 'Authentication Failed', 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email_or_username' => 'required|string',
                'password' => 'required|string',
            ]);

            $field = filter_var($request->email_or_username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

            $credentials = [
                $field => $request->email_or_username,
                'password' => $request->password,
            ];

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $tokenResult = $user->createToken('authToken')->plainTextToken;
                $user->last_login = now();
                $user->save();

                return ResponseFormatter::success([
                    'access_token' => $tokenResult,
                    'token_type' => 'Bearer',
                    'user' => $user,
                ], 'User logged in successfully');
            }

            throw ValidationException::withMessages([
                'auth' => ['The provided credentials are incorrect.'],
            ]);

        } catch (ValidationException $e) {
            // Handling validation errors
            $errors = $e->errors();
            return ResponseFormatter::error([
                'message' => 'Validation failed',
                'errors' => $errors,
            ], 'Authentication Failed', 422);

        } catch (\Exception $e) {
            // Handling other exceptions
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 'Authentication Failed', 500);
        }
    }

    public function profile(Request $request)
    {
        return ResponseFormatter::success($request->user(), 'User profile retrieved successfully');
    }

    public function updateProfile(Request $request)
    {
        try {
            $data = $request->all();

            $user = Auth::user();
            $user->update($data);

            return ResponseFormatter::success($user, 'User profile updated successfully');

        } catch (\Exception $e) {
            // Handling other exceptions
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 'Update profile failed', 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = Auth::user();
            $user->tokens()->delete();

            return ResponseFormatter::success(null, 'User logged out successfully');

        } catch (\Exception $e) {
            // Handling other exceptions
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 'Logout failed', 500);
        }
    }
}
