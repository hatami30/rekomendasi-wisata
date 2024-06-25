<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PasswordResetToken;
use App\Mail\ResetPasswordMail;
use Carbon\Carbon;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $urlGenerator;

    public function __construct(UrlGenerator $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }
    
    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:' . implode(',', [User::ROLE_ADMIN, User::ROLE_USER]),
            'preferences' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'),
            'preferences' => json_encode($request->input('preferences', [])),
        ]);

        if ($user) {
            session()->flash('success', 'Registrasi berhasil! Selamat datang di Website.');

            return response()->json([
                'message' => 'Registrasi sukses! Silakan login...',
                'redirect_url' => $this->urlGenerator->to('/login'),
            ]);
        } else {
            return response()->json(['error' => 'Registrasi gagal'], 500);
        }
    }

    public function showRegistrationForm()
    {
        return view('pages.auth.register');
    }

    /**
     * Authenticate the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $user = auth()->user();
            $roles = [$user->role];

            if (in_array(User::ROLE_ADMIN, $roles)) {
                Session::flash('success', 'Login berhasil! Selamat datang, admin.');
                return redirect()->route('admin.dashboard');
            } elseif (in_array(User::ROLE_USER, $roles)) {
                $previousUrl = Session::get('previousUrl');
                Session::put('previousUrl', URL::previous());
                return Redirect::to($previousUrl);
            }
        }

        Session::flash('error', 'Kesalahan login. Silakan coba lagi.');

        return redirect('/login')->with('error', 'Kesalahan login. Silakan coba lagi.');
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $roles = [$user->role];

            if (in_array('admin', $roles)) {
                return redirect()->route('admin.dashboard');
            } elseif (in_array('user', $roles)) {
                return redirect()->route('wisata');
            }
        }

        return view('pages.auth.login');
    }

    /**
     * Log the user out.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): RedirectResponse
    {
        $previousUrl = URL::previous();
        Session::put('previousUrl', $previousUrl);

        Auth::logout();

        return Redirect::to($previousUrl);
    }

    public function forgotForm()
    {
        return view('pages.auth.forgot');
    }

    public function forgotPost(Request $request)
    {
        $customMessage = [
            'email.required'    => 'Email tidak boleh kosong',
            'email.email'       => 'Email tidak valid',
            'email.exists'      => 'Email tidak terdaftar di database',
        ];

        $request->validate([
            'email' => 'required|email|exists:users',
        ], $customMessage);
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan');
        }
    
        $token = Str::random(60);
    
        PasswordResetToken::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );
    
        Mail::to($user->email)->send(new ResetPasswordMail($token));
    
        return redirect()->back()->with('message', 'Email pemulihan kata sandi telah dikirim.');
    }

    public function resetForm($token)
    {
        $tokenData = PasswordResetToken::where('token', $token)->first();

        if (!$tokenData) {
            return redirect()->route('forgot.form')->with('error', 'Token tidak valid');
        }

        return view('pages.auth.reset', ['token' => $token]);
    }

    public function resetPost(Request $request, $token) 
    {
        $customMessage = [
            'password.required' => 'Password tidak boleh kosong',
            'password.min'      => 'Password minimal 8 karakter',
        ];

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ], $customMessage);
    
        $tokenData = PasswordResetToken::where('token', $token)->first();
    
        if (!$tokenData) {
            return redirect()->back()->with('error', 'Token tidak valid');
        }
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak valid');
        }
    
        $user->password = Hash::make($request->password);
        $user->save();
    
        $tokenData->delete();
    
        return redirect()->route('login')->with('message', 'Kata sandi berhasil direset. Silakan login.');
    }
}
