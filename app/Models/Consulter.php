<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Consulter extends Model implements  AuthenticatableContract
{
    use Authenticatable , Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'specialty',
    ];

    public function calender():HasMany
    {
        return $this->hasMany(Calender::class);
    }
}
