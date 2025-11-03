<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletPayment extends Model
{
    protected $fillable = [
        'wallet_id',
        'amount',
        'status',
        'user_id',
        'ref_id',
        'ref_number',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function wallet():BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }


}
