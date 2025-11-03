<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    protected $fillable = [
        'user_id',
        'current_balance',
        'remaining_balance',
    ];
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function walletPayments():HasMany
    {
        return $this->hasMany(WalletPayment::class);
    }
}
