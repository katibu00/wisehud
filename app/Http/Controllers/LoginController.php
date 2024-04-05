<?php

namespace App\Http\Controllers;

use App\Models\Charges;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;



class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email_or_phone' => 'required',
            'password' => 'required',
        ]);

        $credentials = $this->getCredentials($request);
        $rememberMe = $request->filled('remember_me');

        try {
            if (Auth::attempt($credentials, $rememberMe)) {
                if ($request->ajax()) {
                    return response()->json(['success' => true, 'redirect_url' => $this->getRedirectUrl()]);
                } else {
                    return redirect()->route($this->getRedirectRoute());
                }
            } else {
                throw ValidationException::withMessages([
                    'login_error' => 'Invalid credentials.',
                ]);
            }
        } catch (ValidationException $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'errors' => $e->errors()], 422);
            } else {
                return redirect()->back()->withErrors($e->errors())->withInput()->with('error_message', 'Invalid credentials.');
            }
        }
    }

    protected function getCredentials(Request $request)
    {
        $field = filter_var($request->email_or_phone, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        return [
            $field => $request->email_or_phone,
            'password' => $request->password,
        ];
    }

    protected function getRedirectRoute()
    {
        $userType = auth()->user()->user_type;

        return $userType === 'admin' ? 'admin.home' : 'regular.home';
    }

    protected function getRedirectUrl()
    {
        return route($this->getRedirectRoute());
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function apiLogin(Request $request)
    {
        $request->validate([
            'email_or_phone' => 'required|string',
            'password' => 'required|string',
        ]);
    
        $field = filter_var($request->input('email_or_phone'), FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
    
        $credentials = [
            $field => $request->input('email_or_phone'),
            'password' => $request->input('password'),
        ];
    
        if (auth()->attempt($credentials)) {
            $user = auth()->user();
    
            // Revoke existing tokens
            $user->tokens->each->delete();
    
            // Generate a new token
            $token = $user->createToken('AuthToken')->plainTextToken;
    
            $userData = [
                'name' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
            ];
    
            // Retrieve wallet balance
            $walletBalance = $user->wallet->balance;
    
            // Retrieve reserved accounts
            $reservedAccounts = $user->reservedAccounts;
    
            $charges = Charges::first();

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'access_token' => $token,
                'user' => $userData,
                'wallet_balance' => $walletBalance,
                'reserved_accounts' => $reservedAccounts,
                'whatsapp_group_link' => $charges->whatsapp_group_link,
            ], 200);
        }
    
        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials',
        ], 401);
    }

    public function apiLogout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout successful']);
    }
    
}
