<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;


use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens as PassportHasApiTokens;


/**
 * Summary of Admin
 */
class Admin extends Authenticatable
{
    use  PassportHasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'company_name',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function admin_profile(){
        return $this->hasOne(Admin_Profile::class);
    }
}
