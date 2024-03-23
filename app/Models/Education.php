<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;
    protected $fillable=['name','type','first_date','last_date','grade'];
    public function user_profile(){
        return $this->hasOne(User_Profile::class);

    }


}
