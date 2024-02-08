<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservedAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_reference',
        'customer_email',
        'customer_name',
        'accounts',
    ];
}
