<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'UserID';  
    protected $fillable = [
        'Username', 'Password', 'Email', 'NamaLengkap', 'Alamat', 'Role'
    ];

    protected $hidden = [
        'Password',
    ];

     public function getAuthPassword()
    {
        return $this->Password;
    }
}