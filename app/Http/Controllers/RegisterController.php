<?php
namespace App\Http\Controllers;

use App\Models\ReservedAccount;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{


    public function index()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string|unique:users',
            'email' => 'nullable|email|unique:users',
            'referral_code' => 'nullable|string',
            'password' => 'required|min:6',
        ]);
        


        $fullName = $validatedData['name'];
        $firstName = explode(' ', $fullName)[0]; // Extract the first name
        $randomString = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 4);
        $username = $firstName . $randomString;


       // Create the user account
        $user = User::create([
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
            'email' => $validatedData['email'],
            'referral_code' => $validatedData['referral_code'],
            'username' => $username.$randomString,
            'password' => Hash::make($validatedData['password']),
        ]);

        try {
            // Get the Monnify access token
            $accessToken = $this->getAccessToken();

            // Create Monnify reserved account
            $monnifyReservedAccount = $this->createMonnifyReservedAccount($user, $accessToken);

            // Save Monnify reserved account details in the reserved_accounts table
            ReservedAccount::create([
                'user_id' => $user->id,
                'customer_email' => $monnifyReservedAccount->customerEmail,
                'customer_name' => $monnifyReservedAccount->customerName,
                'accounts' => json_encode($monnifyReservedAccount->accounts), // Convert the object to JSON string
            ]);

            // Create a wallet for the user
            Wallet::create([
                'user_id' => $user->id,
                'balance' => 0, // Set initial balance to 0
            ]);

            // Return a success response
            return response()->json(['message' => 'User registered successfully']);
        } catch (\Exception $e) {
            // Handle any exceptions or errors here
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function getAccessToken()
    {
        // Fetch API key and secret key from configuration or environment variables
        $apiKey = "MK_TEST_U8HB3APP2Q";
        $secretKey = "WG3ZRMG3VRXX9QJD25HJBXQY2FFPH363";

        // Encoding Monnify API_KEY and SECRET KEY
        $encodedKey = base64_encode($apiKey . ':' . $secretKey);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sandbox.monnify.com/api/v1/auth/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                "Authorization: Basic $encodedKey",
            ),
        ));

        $response = curl_exec($curl);
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            throw new \Exception("cURL Error: " . $err);
        }

        if ($httpStatus !== 200) {
            throw new \Exception("Monnify API request failed. Error Response: " . $response);
        }

        $monnifyResponse = json_decode($response);

        if (!$monnifyResponse->requestSuccessful) {
            throw new \Exception($monnifyResponse->responseMessage);
        }

        return $monnifyResponse->responseBody->accessToken;
    }

    private function createMonnifyReservedAccount(User $user, $accessToken)
    {
        // Generate account reference and account name
        $accountReference = uniqid('abc', true);
        $accountName = $user->name;

        // Other required parameters
        $currencyCode = 'NGN';
        $contractCode = '5027608904';
        $customerEmail = $user->email;
        $customerName = $user->name;
        $getAllAvailableBanks = true;

        $data = [
            'accountReference' => $accountReference,
            'accountName' => $accountName,
            'currencyCode' => $currencyCode,
            'contractCode' => $contractCode,
            'customerEmail' => $customerEmail,
            'customerName' => $customerName,
            'getAllAvailableBanks' => $getAllAvailableBanks,
        ];

        $jsonData = json_encode($data);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sandbox.monnify.com/api/v2/bank-transfer/reserved-accounts',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $accessToken,
            ),
        ));

        $response = curl_exec($curl);
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            throw new \Exception("cURL Error: " . $err);
        }

        if ($httpStatus !== 200) {
            throw new \Exception("Monnify API request failed. Error Response: " . $response);
        }

        $monnifyResponse = json_decode($response);

        if (!$monnifyResponse->requestSuccessful) {
            throw new \Exception($monnifyResponse->responseMessage);
        }

        return $monnifyResponse->responseBody;
    }
}
