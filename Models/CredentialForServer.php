<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CredentialForServer extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'credential_for',
        'email',
        'mobile',
        'url',
        'ip_address',
        'username',
        'password',
    ];
}
