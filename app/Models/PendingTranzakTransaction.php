<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingTranzakTransaction extends Model
{
    use HasFactory;

    protected $connection = "mysql2";
    protected $fillable = [
        "request_id", "amount", "currency_code","description","transaction_ref","app_id", 
        'transaction_time', 'payment_type', 'user_type', "payment_id", "student_id", 
        "batch_id", 'unit_id', "original_amount", "reference_number", 'paid_by', 'purpose'
    ];

    public function student(){
        return $this->belongsTo(Students::class, 'student_id');
    }
}
