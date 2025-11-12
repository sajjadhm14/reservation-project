<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'current_balance',
        'remaining_balance',
    ];

    /**
     * @param $user
     * @return mixed
     */
    public static function createUserWallet($user)
    {
        return Wallet::firstOrCreate(['user_id'=>$user]);
    }

    /**
     * @param $user
     * @return mixed
     */
    public static function GetUserWallet($user)
    {
        return wallet::where('user_id' , $user)->first();
    }

    /**
     * @return BelongsTo
     */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function walletPayments():HasMany
    {
        return $this->hasMany(WalletPayment::class);
    }
}
