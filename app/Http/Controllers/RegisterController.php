<?php
namespace App\Http\Controllers;

use App\Models\Charges;
use App\Models\ReservedAccount;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{

    public function index()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string',
                'referral_code' => 'nullable|string',
                'phone' => 'required|string|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ]);
            
            // Check if the select field value is 'bvn' or 'nin'
            if ($request->input('bvn_nin_select') === 'bvn') {
                // If 'bvn' is selected, add validation rule for 'bvn' field
                $bvnValidation = $request->validate([
                    'bvn' => ['required', 'string', 'regex:/^\d{11}$/'],
                ]);
            
                // Merge the validation rules with existing validatedData
                $validatedData = array_merge($validatedData, $bvnValidation);
            } elseif ($request->input('bvn_nin_select') === 'nin') {
                // If 'nin' is selected, add validation rule for 'nin' field
                $ninValidation = $request->validate([
                    'nin' => ['required', 'string', 'regex:/^\d{11}$/'],
                ]);
            
                // Merge the validation rules with existing validatedData
                $validatedData = array_merge($validatedData, $ninValidation);
            }
            // dd($validatedData);
            $fullName = $validatedData['name'];
            $firstName = explode(' ', $fullName)[0];
            $randomString = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 4);
            $username = $firstName . $randomString;

            // Create a user instance
            $user = new User([
                'name' => $validatedData['name'],
                'phone' => $validatedData['phone'],
                'email' => $validatedData['email'],
                'referral_code' => $validatedData['referral_code'],
                'username' => $username . $randomString,
                'password' => Hash::make($validatedData['password']),
            ]);

            // Get the Monnify access token
            $accessToken = $this->getAccessToken();

            // Create Monnify reserved account
            $monnifyReservedAccount = $this->createMonnifyReservedAccount($user, $accessToken, $validatedData);

            // Save user and Monnify account details
            $user->save();
            ReservedAccount::create([
                'user_id' => $user->id,
                'account_reference' => $monnifyReservedAccount->accountReference,
                'customer_email' => $monnifyReservedAccount->customerEmail,
                'customer_name' => $monnifyReservedAccount->customerName,
                'accounts' => json_encode($monnifyReservedAccount->accounts),
            ]);

            // Create a wallet with welcome bonus
            $welcome_bonus = Charges::select('welcome_bonus')->first();
            Wallet::create([
                'user_id' => $user->id,
                'balance' => $welcome_bonus->welcome_bonus,
            ]);

            DB::commit(); // Commit the transaction
            return response()->json(['message' => 'User account created successfully']);
        } catch (\Exception $e) {
            DB::rollback(); // Rollback the transaction on exception
            Log::error('Registration Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function getAccessToken()
    {
        $monnifyKeys = DB::table('monnify_keys')->first();
        $apiKey = $monnifyKeys->public_key;
        $secretKey = $monnifyKeys->secret_key;

        $encodedKey = base64_encode($apiKey . ':' . $secretKey);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.monnify.com/api/v1/auth/login',
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

    private function createMonnifyReservedAccount(User $user, $accessToken, $validatedData)
    {
        $accountReference = uniqid('abc', true);
        $accountName = $user->name;

        $monnifyKeys = DB::table('monnify_keys')->first();
        $contractCode = $monnifyKeys->contract_code;

        $currencyCode = 'NGN';
        $contractCode = $contractCode;
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
            'bvn' => $validatedData['bvn'] ?? null,
            'nin' => $validatedData['nin'] ?? null,
        ];

        $jsonData = json_encode($data);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.monnify.com/api/v2/bank-transfer/reserved-accounts',
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
