<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class WalletPayment extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'wallet_id',
        'amount',
        'status',
        'user_id',
        'ref_id',
        'ref_number',
    ];

    /**
     * @return mixed
     */
    public static function getUserWallet()
    {
        return WalletPayment::where('user_id' , Auth::guard('web')->id())
            ->orderby('created_at' , 'desc')
            ->take(5)
            ->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function getPaymentRefId($data)
    {
        return WalletPayment::where('ref_id' ,$data)->firstOrFail();
    }

    /**
     * @return BelongsTo
     */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */

    public function wallet():BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }


}
