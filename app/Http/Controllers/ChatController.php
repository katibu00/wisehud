<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function submit(Request $request)
    {
        // Retrieve form data from the request
        $prompt = $request->input('prompt');

        // Set the API endpoint URL
        $url = 'https://api.openai.com/v1/chat/completions';

        // Set the request payload
        $payload = [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
            'temperature' => 0.7,
        ];

        // Convert the payload to JSON
        $jsonPayload = json_encode($payload);

        // Set the cURL options
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer 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',
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);

        // Send the cURL request
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            // Handle the error as needed
            // For example, return an error response
            return response()->json(['error' => $error], 500);
        }

        // Close the cURL session
        curl_close($ch);

        // Process the API response
        $result = json_decode($response, true);
       
        if (isset($result['error'])) {
            $errorMessage = $result['error']['code'];
            return response()->json(['completion' => $errorMessage]);
        }

        // Get the generated completion from the response
        $completion = $result['choices'][0]['message']['content'];

        // Return the generated completion as a response
        return response()->json(['completion' => $completion]);
    }
}
