<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationForm extends Model
{
    use HasFactory;

    protected $nullables = [];
    protected $connection = 'mysql2';
    protected $dates = ['admitted_at', 'dob', 'created_at', 'updated_at'];
    protected $fillable = [
        'student_id', 'year_id', 'gender', 'name', 'dob', 'pob', 
        'nationality', 'region', 'division', 'residence', 'phone', 
        'email', 'program_first_choice', 'program_second_choice', 
        'special_needs', 'ol_results', 'al_results', 'id_number', 
        'father_name', 'father_address', 'father_tel', 'mother_name', 
        'mother_address', 'mother_tel', 'guardian_name', 'guardian_address', 
        'guardian_tel', 'matric', 'candidate_declaration', 'parent_declaration', 
        'campus_id', 'degree_id', 'transaction_id', 'admitted',
        'emergency_name', 'emergency_address', 'emergency_tel', 
        'previous_training', 'level', 'marital_status', 'bypass_reason',
        'admitted_at'
    ];

    public function student()
    {
        # code...
        return $this->belongsTo(Students::class, 'student_id');
    }

    public function transaction()
    {
        # code...
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function year()
    {
        # code...
        return $this->belongsTo(Batch::class, 'year_id');
    }

    public function _region()
    {
        # code...
        return $this->belongsTo(Region::class, 'region');
    }

    public function _division()
    {
        # code...
        return $this->belongsTo(Division::class, 'division');
    }

    public function campus_banks()
    {
        return CampusBank::where('campus_id', $this->campus_id);
    }

    public function is_filled()
    {
        # code...
        $data = $this->toArray();
        $null_fields = array_filter(array_keys($data), function($element)use($data){
            return $data[$element] == null;
        });
        // dd($null_fields);
        if (count($null_fields) > 0) {
            # code...
            foreach ($null_fields as $key => $value) {
                # code...
                if(!in_array($value, $this->nullables))
                    return false;
            }
        }
        return true;

    }

}
