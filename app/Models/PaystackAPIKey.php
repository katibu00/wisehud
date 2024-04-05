<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaystackAPIKey extends Model
{
    use HasFactory;

    protected $fillable = ['secret_key', 'public_key'];

}
