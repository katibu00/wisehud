<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonnifyKey extends Model
{
    use HasFactory;


    protected $fillable = [
        'public_key',
        'secret_key',
        'contract_code',
    ];
}
