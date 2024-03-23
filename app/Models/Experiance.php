<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experiance extends Model
{
    use HasFactory;
    protected $fillable=['name','description','first_date','last_date','company_name'];

    public function user_profile(){
        return $this->hasOne(User_Profile::class);
    }
}
