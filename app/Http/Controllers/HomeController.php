<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReservedAccount;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\MonnifyTransfer;
use App\Models\PopUp;
use Carbon\Carbon;

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


      $popUp = PopUp::where('switch', 'on')->first();

    return view('home.regular', compact('accounts', 'popUp'));

    }



    public function admin()
    {
        // Get the required statistics
        $totalUsers = User::count();
        $totalWalletBalance = Wallet::sum('balance');
        $totalFundings = MonnifyTransfer::sum('amount_paid');
        
        // Calculate the number of active users based on the last login time (within the last 30 days)
        $activeUsers = User::where('created_at', '>=', Carbon::now()->subDays(30))->count();
    
        // Calculate the number of new users (registered within the last 30 days)
        $newUsers = User::where('created_at', '>=', Carbon::now()->subDays(30))->count();
    
        // Pass the statistics to the view
        return view('admin.home', compact('totalUsers', 'totalWalletBalance', 'totalFundings', 'activeUsers', 'newUsers'));

    }
    
    
    
    
    
    
    


}
