<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonnifyTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_reference',
        'payment_reference',
        'paid_on',
        'payment_description',
        'payment_source_information',
        'destination_account_information',
        'amount_paid',
        'settlement_amount',
        'payment_status',
        'customer_name',
        'customer_email',
        'bankCode',
        'amountPaid',
        'accountName',
        'sessionId',
        'accountNumber',
        'bankName',
        'name',
        'email',

    ];
    
}
