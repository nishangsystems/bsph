<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = "transactions";
    protected $connection = 'mysql2';
    protected $fillable = ['student_id', 'amount', 'year_id', 'tel', 'status','payment_purpose','payment_method','reference', 'transaction_id', 'payment_id', 'financialTransactionId', 'used', 'is_charges', 'semester_id'];
}
