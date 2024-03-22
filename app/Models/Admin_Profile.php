<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin_Profile extends Model
{
    use HasFactory;
    protected $fillable=['company_name','location','link','created_date','admin_id'];
public function admin(){
    return $this->belongsTo(Admin::class);
}

}
