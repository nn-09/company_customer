<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Profile extends Model
{
    use HasFactory;
    protected $fillable=['first_name','middle_name','last_name','age','gender','user_id',];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function experiances(){
        return $this->hasMany(Experiance::class);
    }

    public function skills(){
        return $this->hasMany(Skills::class);

    }


    public function educatios(){
        return $this->hasMany(Education::class);

    }
    public function interestins(){
        return $this->hasMany(Interesting::class);

    }

}
