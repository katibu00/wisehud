<?php

namespace App\Http\Controllers;

use App\Models\MonnifyTransfer;
use App\Models\ReservedAccount;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MonnifyController extends Controller
{

    public function getTransfers(Request $request)
    {
        $payload = $request->all();
        $paymentSourceInformation = $payload['eventData']['paymentSourceInformation'][0];
        $amountPaid = $paymentSourceInformation['amountPaid'];
        $customerEmail = $payload['eventData']['customer']['email'];

        $reservedAccount = ReservedAccount::where('customer_email', $customerEmail)->first();

        if ($reservedAccount) {
            // Retrieve the user's wallet
            $wallet = Wallet::where('user_id', $reservedAccount->user_id)->first();

            if ($wallet) {
                $wallet->balance += $payload['eventData']['settlementAmount'];
                $wallet->save();

                MonnifyTransfer::create([
                    'transaction_reference' => $payload['eventData']['transactionReference'],
                    'payment_reference' => $payload['eventData']['paymentReference'],
                    'paid_on' => $payload['eventData']['paidOn'],
                    'payment_source_information' => json_encode($paymentSourceInformation),
                    'destination_account_information' => json_encode($payload['eventData']['destinationAccountInformation']),
                    'amount_paid' => $amountPaid,
                    'settlement_amount' => $payload['eventData']['settlementAmount'],
                    'payment_status' => $payload['eventData']['paymentStatus'],
                    'customer_name' => $payload['eventData']['customer']['name'],
                    'customer_email' => $customerEmail,
                ]);

                return response('Webhook received', 200);
            }
        }

        return response('Reserved account or wallet not found', 404);
    }

}
