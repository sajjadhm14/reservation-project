<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'wallet_id',
        'amount',
        'description',
        'user_id',
        'ref_id',
        'ref_number',
    ];


}
