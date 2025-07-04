<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    use HasFactory;
    protected $fillable = ['phone'];
    protected $table = 'phone_numbers';
    protected $connection = 'mysql2';

}
