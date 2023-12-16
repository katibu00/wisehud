<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ReservedAccount;

class WalletControler extends Controller
{
    public function index()
    {

        $query = ReservedAccount::where('customer_email', auth()->user()->email)->first();

        if ($query) {
            $accounts = json_decode($query->accounts, true);
        } else {
            $accounts = [];
        }

        return view('wallet.index', compact('accounts'));

    }

    public function getWalletBalance(Request $request)
    {
        // Get the authenticated user
        $user = $request->user();

        // Retrieve the wallet balance for the user
        $walletBalance = $user->wallet->balance;

        return response()->json([
            'success' => true,
            'wallet_balance' => $walletBalance,
        ]);
    }
}
