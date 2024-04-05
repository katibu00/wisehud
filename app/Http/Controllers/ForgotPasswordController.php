<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BrevoAPIKey;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

   
    public function sendResetLinkEmail(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Check if the email exists in the database
        $userExists = DB::table('users')->where('email', $request->email)->exists();

        // If the email doesn't exist, redirect back with an error message
        if (!$userExists) {
            return back()->withErrors(['email' => 'Invalid email address. Please make sure you entered the correct email.'])->withInput();
        }

        $existingToken = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        $token = Str::random(64);

        // Insert token into password_resets table
        if ($existingToken) {
            // If the email already exists, update the existing record
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->update([
                    'token' => $token,
                    'created_at' => now(),
                ]);
        } else {
            // If the email doesn't exist, insert a new record
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => now(),
            ]);
        }

        // Generate the reset password link
        $resetLink = route('password.reset', ['token' => $token, 'email' => $request->email]);

        // Prepare email body
        $emailBody = "Hello!<br><br>" .
            "We've received a request to reset the password for your account associated with the email address: " . $request->email .
            ".<br><br>To reset your password, simply click on the button below:<br><br>" .
            "<a href='" . $resetLink . "' style='display: inline-block; background-color: #4CAF50; color: white; padding: 10px 20px; text-align: center; text-decoration: none; border-radius: 5px;'>Reset Password</a><br><br>" .
            "If you didn't request a password reset, you can safely ignore this email.<br><br>" .
            "Thank you!<br>Wisehud AI Team";

        // Send the reset password email
        $this->sendResetPasswordLinkEmail($request->email, $emailBody);

        // Redirect back with success message
        return redirect()->route('login')->with('success', 'Password Reset Link Sent Successfully. Check your email to continue reseting your password.');
    }



    public function showResetPasswordForm(Request $request, $token = null)
    {
        return view('auth.reset-password')->with(['token'=>$token,'email'=>$request->email]);
    }




public function resetPassword(Request $request)
{
    // Validate the request data
    $validator = Validator::make($request->all(), [
        'email' => 'required|email|exists:users,email',
        'token' => 'required',
        'password' => 'required|min:6|confirmed',
    ]);

    // If validation fails, redirect back with errors
    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    // Check if the token is valid for the given email
    $checkToken = DB::table('password_reset_tokens')
        ->where('email', $request->email)
        ->where('token', $request->token)
        ->first();

    // If the token is invalid, redirect back with an error message
    if (!$checkToken) {
        return back()->withErrors(['token' => 'Invalid Token'])->withInput();
    }

    // Update the user's password
    User::where('email', $request->email)
        ->update([
            'password' => Hash::make($request->password)
        ]);

    // Delete the used token from the password_resets table
    DB::table('password_reset_tokens')
        ->where('email', $request->email)
        ->delete();

    // Redirect back with success message
    return redirect()->route('login')->with('success', 'Password Reset Successfully. You can now login with your new password.');
}



    private function sendResetPasswordLinkEmail($userEmail, $body)
    {
        $apiKey = BrevoAPIKey::first()->api_key ?? '';

        $endpoint = 'https://api.brevo.com/v3/smtp/email';

        // Email data
        $senderName = 'Wisehu AI';
        $senderEmail = 'support@wisehud.com';
        $recipientEmail = $userEmail;
        $subject = 'Password Reset Request';

        // Modify the HTML content for booking notification to the doctor
        $htmlContent = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Password Reset Request</title>
            <style>
                /* Add your custom styles here */
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f7f7f7;
                    margin: 0;
                    padding: 0;
                    line-height: 1.6;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                    background-color: #fff;
                    border-radius: 8px;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                }
                .message {
                    margin-top: 30px;
                }
                .message p {
                    margin-bottom: 20px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="message">
                    ' . $body . '
                   
                </div>
            </div>
        </body>
        </html>';

        // Prepare the data payload
        $data = [
            'sender' => [
                'name' => $senderName,
                'email' => $senderEmail,
            ],
            'to' => [
                [
                    'email' => $recipientEmail,
                ],
            ],
            'subject' => $subject,
            'htmlContent' => $htmlContent,
        ];

        // Send the HTTP request
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'api-key' => $apiKey,
            'content-type' => 'application/json',
        ])->post($endpoint, $data);

       
    }
}
