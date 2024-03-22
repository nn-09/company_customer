<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin_Image extends Model
{
    use HasFactory;
    protected $fillable=['path','admin_id'];
    public function admin(){
        return $this->belongsTo(Admin::class);
    }
    







}
