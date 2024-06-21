<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $fillable = ['year_id', 'start_date', 'end_date', 'fee1_latest_date', 'fee2_latest_date', 'director', 'dean', 'help_email', 'start_of_lectures'];
    protected $dates =  ['start_date', 'end_date', 'fee1_latest_date', 'fee2_latest_date', 'start_of_lectures'];
    protected $connection = 'mysql2';

    public function batch(){
        return $this->belongsTo(Batch::class, 'year_id');
    }

}
