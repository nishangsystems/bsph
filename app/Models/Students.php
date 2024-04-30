<?php

namespace App\Models;

use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class Students extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'gender',
        'username',
        'matric',
        'dob',
        'pob',
        'campus_id',
        'admission_batch_id',
        'password',
        'parent_name',
        'program_id',
        'parent_phone_number',
        'imported',
        'active'
    ];
    protected $connection = 'mysql2';


    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }


    
    



    // FOR APPLICATION PORTAL ONLY
    public function currentApplicationForms($year = null)
    {
        $year = $year == null ? Helpers::instance()->getCurrentAccademicYear() : $year;
        return $this->hasMany(ApplicationForm::class, 'student_id')->where('application_forms.year_id', $year);
    }

    public function applicationForms()
    {
        return $this->hasMany(ApplicationForm::class, 'student_id');
    }

    public function paid_charges()
    {
        # code...
        return $this->hasMany(Charge::class, 'student_id');
    }

    public function hasPaidPlatformCharges($year_id = null)
    {
        $year = $year_id == null ? \App\Helpers\Helpers::instance()->getCurrentAccademicYear() : $year_id;
        $batch = Batch::find($year);
        if($batch->pay_charges == 0)
            return true;
        $plcharge = PlatformCharge::where('year_id', $year)->first();
        if($plcharge == null || $plcharge->yearly_amount == null || $plcharge->yearly_amount <= 0)
            return true;
        $charge = Charge::where(['student_id'=> $this->id, 'type'=>'PLATFORM', 'year_id'=>$year])->whereNotNull('amount')->first();
        if($charge == null)
            return false;
        return true;
    }

}
