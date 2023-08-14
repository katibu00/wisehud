<?php

namespace App\Http\Controllers;

use App\Models\ReservedAccount;
use Illuminate\Http\Request;

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
}
