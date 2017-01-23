<?php

namespace App;

use Laravel\Passport\HasApiTokens;

use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasApiTokens, Notifiable;
}
