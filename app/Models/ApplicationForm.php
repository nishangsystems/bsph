<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationForm extends Model
{
    use HasFactory;

    protected $nullables = [];
    protected $connection = 'mysql2';
    protected $dates = ['admitted_at', 'dob', 'created_at', 'updated_at', 'date_from', 'date_to'];
    protected $fillable = [
        'student_id', 'year_id', 'gender', 'name', 'dob', 'pob', 
        'nationality', 'region', 'division', 'residence', 'phone', 
        'phone_2', 'email', 'program_first_choice', 'program_second_choice', 
        'program_third_choice', 'father_name', 'father_address', 'father_tel', 'mother_name', 
        'mother_address', 'mother_tel', 'guardian_name', 'guardian_address', 
        'guardian_tel', 'matric', 'candidate_declaration', 'parent_declaration', 
        'campus_id', 'degree_id', 'transaction_id', 'admitted', 'schools_attended',
        'health_condition', 'ol_results', 'al_results', 'id_number', 'enrollment_purpose',
        'id_date_of_issue', 'id_expiry_date', 'id_place_of_issue', 'disability',
        'emergency_name', 'emergency_address', 'emergency_tel', 'emergency_email', 
        'fee_payment_channel', 'emergency_personality', 'previous_training', 'level', 
        'marital_status', 'bypass_reason', 'admitted_at', 'info_source', 'info_source_identity'
    ];

    public function firstName(){
        if($this->name != null){
            $tokens = explode(' ', $this->name);
            if(count($tokens) > 3){
                $first_name = $tokens[0]." ".$tokens[1];
            }else{
                $first_name = $tokens[0];
            }
            return $first_name;
        }
        return '';
    }
    public function otherNames(){
        if($this->name != null){
            $last_name = '';
            $tokens = explode(' ', $this->name);
            if(count($tokens) > 3){
                $last_name = $tokens[2]." ".$tokens[3];
            }elseif(count($tokens) != 1){
                $last_name = $tokens[1];
            }
            return $last_name;
        }
        return '';
    }

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
