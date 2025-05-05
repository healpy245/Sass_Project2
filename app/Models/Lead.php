<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = ['name','phone','email','address','ID_number','user_id','company_id'];



}
