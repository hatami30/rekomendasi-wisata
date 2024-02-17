<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:user,admin',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'),
        ]);

        if ($user) {
            session()->flash('success', 'Registrasi berhasil! Selamat datang di Website.');

            $loginUrl = URL::to('/login');

            return response()->json([
                'message' => 'Registrasi sukses! Silahkan login...',
                'redirect_url' => $loginUrl,
            ]);
        } else {
            return response()->json(['error' => 'Registrasi gagal'], 500);
        }
    }

    /**
     * Authenticate the user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (auth()->attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $user = auth()->user();
            $roles = [$user->role];

            if (in_array('admin', $roles)) {
                return redirect()->route('admin.dashboard');
            } elseif (in_array('user', $roles)) {
                return redirect()->route('user.dashboard');
            }
        }

        return redirect('/login')->with('error', 'Invalid credentials');
    }

    /**
     * Log the user out.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Berhasil keluar.'], 200);
    }
}
