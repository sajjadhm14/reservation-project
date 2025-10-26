<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

use Illuminate\Database\Eloquent\Model;
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
}
