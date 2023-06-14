<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReservedAccount;

class HomeController extends Controller
{
    public function regular()
    {


    $query = ReservedAccount::where('user_id', auth()->user()->id)->first();

    if ($query) {
        $accounts = json_decode($query->accounts, true);
    } else {
        $accounts = [];
    }



        return view('home.regular', compact('accounts'));
    }

    public function admin()
    {
        return view('home.admin');

    }

}
