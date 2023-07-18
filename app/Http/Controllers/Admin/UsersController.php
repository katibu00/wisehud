<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ManualFunding;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function regular()
    {
        $users = User::where('user_type', 'regular')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.users.regular.index', compact('users'));
    }
    public function admins()
    {
        $users = User::where('user_type', 'admin')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.users.admin.index', compact('users'));
    }




    public function manualFunding(Request $request)
    {
        $validatedData = $request->validate([
            'userId' => 'required|exists:users,id',
            'userName' => 'required',
            'amount' => 'required|numeric',
        ]);

        $user = User::find($validatedData['userId']);

        // Create a new manual funding record
        $manualFunding = new ManualFunding();
        $manualFunding->user_id = $user->id;
        $manualFunding->amount = $validatedData['amount'];
        $manualFunding->save();

        // Increase the user's wallet balance
        $user->wallet->balance += $validatedData['amount'];
        $user->wallet->save();

        // Perform any additional operations with the manual funding record

        // Return a response indicating success
        return response()->json(['message' => 'Manual funding submitted successfully'], 200);
    }


    public function changePassword(Request $request)
    {
        $request->validate([
            'userId' => 'required|exists:users,id',
            'newPassword' => 'required|min:6',
        ]);

        $user = User::find($request->input('userId'));
        $user->password = Hash::make($request->input('newPassword'));
        $user->save();

        // Return a response indicating success
        return response()->json(['message' => 'Password changed successfully'], 200);
    }


    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Perform any necessary checks or validations before deleting the user

        $user->delete();

        // You can optionally return a response indicating the success of the deletion
        return response()->json(['message' => 'User deleted successfully']);
    }

}
