<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'phone',
        'email',
        'referral_code',
        'password'
    ];

    // Define the relationship with ReservedAccount model
    public function reservedAccounts()
    {
        return $this->hasMany(ReservedAccount::class);
    }

    // Define the relationship with Wallet model
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public static function generateReferralCode()
    {
        $referralCode = Str::random(8); // You can adjust the length as needed
        while (User::where('referral_code', $referralCode)->exists()) {
            $referralCode = Str::random(8);
        }
        return $referralCode;
    }

    public function fundingTransactions(): HasMany
    {
        return $this->hasMany(FundingTransaction::class);
    }


    public function referredUsers(): HasMany
    {
        return $this->hasMany(User::class, 'referred_by');
    }


    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

   
}
