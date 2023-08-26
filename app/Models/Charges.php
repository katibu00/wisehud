<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charges extends Model
{
    use HasFactory;

    protected $fillable = [
        'charges_per_chat',
        'welcome_bonus',
        'referral_bonus',
        'whatsapp_group_link',
        'funding_charges_description',
        'funding_charges_amount',
    ];
}
