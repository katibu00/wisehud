<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Conversation;
use App\Models\OpenAIKey;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ChatController extends Controller
{

    // public function submit(Request $request)
    // {
    //     $prompt = $request->input('prompt');

    //     $user = auth()->user();
    //     $walletBalance = $user->wallet->balance;

    //     $charges = DB::table('charges')->first();
    //     $chargesPerChat = $charges->charges_per_chat;

    //     if ($walletBalance < $chargesPerChat) {
    //         return response()->json(['error' => 'Insufficient balance. Please fund your wallet.']);
    //     }

    //     $openAIKey = OpenAIKey::first();
    //     $apiKey = $openAIKey ? $openAIKey->key : '';

    //     $url = 'https://api.openai.com/v1/chat/completions';

    //     $payload = [
    //         'model' => 'gpt-3.5-turbo',
    //         'messages' => [
    //             ['role' => 'user', 'content' => $prompt],
    //         ],
    //         'temperature' => 0.7,
    //     ];

    //     $jsonPayload = json_encode($payload);

    //     $ch = curl_init($url);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //         'Content-Type: application/json',
    //         'Authorization: Bearer ' . $apiKey,
    //     ]);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);

    //     $response = curl_exec($ch);

    //     if (curl_errno($ch)) {
    //         $error = curl_error($ch);

    //         return response()->json(['error' => $error], 500);
    //     }

    //     curl_close($ch);

    //     $result = json_decode($response, true);

    //     if (isset($result['error'])) {
    //         $errorMessage = $result['error']['code'];
    //         return response()->json(['completion' => $errorMessage]);
    //     }

    //     $user = User::find($user->id);
    //     $userWallet = $user->wallet;
    //     $userWallet->balance -= $chargesPerChat;
    //     $userWallet->save();

    //     $completion = $result['choices'][0]['message']['content'];

    //     return response()->json(['completion' => $completion]);
    // }

    public function index()
    {
        $session_id = Str::uuid();

        // Pass the session ID to the view
        return view('chat.index', ['session_id' => $session_id]);
    }


    public function submit(Request $request)
    {
        $prompt = $request->input('prompt');

        $session_id = $request->input('session_id');

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


       $conversationHistory = Conversation::whereHas('chat', function ($query) use ($session_id) {
            $query->where('session_id', $session_id);
        })
        ->orderBy('id', 'desc')
        ->limit(20)
        ->get();
        
        $messages = [];
        foreach ($conversationHistory as $conversation) {
            // Add user prompt to messages
            $messages[] = ['role' => 'user', 'content' => $conversation->user_prompt];
            // Add bot response to messages
            $messages[] = ['role' => 'assistant', 'content' => $conversation->bot_response];
        }

        // Add current user prompt to messages
        $messages[] = ['role' => 'user', 'content' => $prompt];

        $payload = [
            'model' => 'gpt-3.5-turbo',
            'messages' => $messages,
            'temperature' => 0.7,
            
        ];

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


        $words = str_word_count($prompt, 1);

        if (count($words) > 10) {
            $chatTitle = implode(' ', array_slice($words, 0, 10));
        } else {
            // Otherwise, use the entire prompt as the chat title
            $chatTitle = $prompt;
        }

        $chatTitle = str_word_count($prompt, 1) > 10 ? implode(' ', array_slice(str_word_count($prompt, 1), 0, 10)) : $prompt;

        // Find existing chat or create a new one
        $chat = Chat::where('session_id', $session_id)->first();
        if (!$chat) {
            $chat = new Chat();
            $chat->title = $chatTitle;
            $chat->user_id = $user->id;
            $chat->session_id = $session_id;
            $chat->save();
        }
    
        // Create a new conversation
        $conversation = new Conversation();
        $conversation->chat_id = $chat->id;
        $conversation->user_prompt = $prompt;
        $conversation->bot_response = $result['choices'][0]['message']['content'];
        $conversation->save();



        return response()->json(['completion' => $completion]);
    }


    public function chatHistory()
    {
        $user = auth()->user();

        $chats = Chat::where('user_id', $user->id)->get();

        return view('chat.history', compact('chats'));
    }



    public function chatDetails($sessionId)
    {
        // Fetch the chat details using the session ID
        $chat = Chat::where('session_id', $sessionId)->first();

        // If the chat does not exist, return an error message or redirect as needed
        if (!$chat) {
            return response()->json(['error' => 'Chat not found'], 404);
            // Alternatively, you can redirect to another page:
            // return redirect()->route('chat.history')->with('error', 'Chat not found');
        }

        // Fetch the conversations related to this chat
        $conversations = Conversation::where('chat_id', $chat->id)->get();

        // Pass the chat details and conversations to the view
        return view('chat.details', compact('chat', 'conversations','sessionId'));
    }




    

}
