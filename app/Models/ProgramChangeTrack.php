<?php

namespace App\Models;

use App\Http\Services\ApiService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramChangeTrack extends Model
{
    use HasFactory;

    protected $table = "program_change_tracks";
    protected $connection = "mysql2";
    protected $fillable = ['former_program', 'current_program', 'form_id', 'user_id'];

    public function form(){
        return $this->belongsTo(ApplicationForm::class, 'form_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
