<?php

namespace App\Http\Controllers;

use App\Models\OpenAIKey;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{

    public function submit(Request $request)
    {
        $prompt = $request->input('prompt');

        // return response()->json(['completion' => 'Hi my guy how are and your famuly mala hassan']);

        $user = auth()->user();
        $walletBalance = $user->wallet->balance;

        $charges = DB::table('charges')->first();
        $chargesPerChat = $charges->charges_per_chat;

        if ($walletBalance < $chargesPerChat) {
            return response()->json(['error' => 'Insufficient balance. Please fund your wallet.']);
        }

        $openAIKey = OpenAIKey::first();
        $apiKey = $openAIKey ? $openAIKey->key : '';

        $url = 'https://api.openai.com/v1/chat/completions';

        $payload = [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
            'temperature' => 0.7,
        ];

        $jsonPayload = json_encode($payload);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey,
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error = curl_error($ch);

            return response()->json(['error' => $error], 500);
        }

        curl_close($ch);

        $result = json_decode($response, true);

        if (isset($result['error'])) {
            $errorMessage = $result['error']['code'];
            return response()->json(['completion' => $errorMessage]);
        }

        $user = User::find($user->id);
        $userWallet = $user->wallet;
        $userWallet->balance -= $chargesPerChat;
        $userWallet->save();

        $completion = $result['choices'][0]['message']['content'];

        return response()->json(['completion' => $completion]);
    }

    public function index()
    {
        return view('chat.index');
    }
}
