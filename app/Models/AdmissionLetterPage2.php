<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionLetterPage2 extends Model
{
    use HasFactory;
    protected $table="admission_letter_page2";
    protected $fillable=['content', 'program_id'];
    protected $connection = 'mysql2';
}
