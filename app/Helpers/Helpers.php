<?php

namespace App\Helpers;

use App\Models\Batch;
use App\Models\Charge;
use App\Models\Config;
use App\Models\File;
use App\Models\PlatformCharge;
use App\Models\ProgramLevel;
use App\Models\Resit;
use App\Models\Result;
use App\Models\SchoolUnits;
use App\Models\Students;
use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Helpers
{
    public function getYear()
    {
        return session()->get('mode', $this->getCurrentAccademicYear());
    }

    public function getCurrentAccademicYear()
    {
        $config = \App\Models\Config::all()->last();
        return $config->year_id;
    }

    public function letterHead()
    {
        return File::where('name', 'letter-head')->first()->path ?? '';
    }

    public function bgImage()
    {
        return File::where('name', 'bg-image')->where('campus_id', auth()->user()->campus_id)->first()->path ?? '';
    }

    public function getCurrentSemester()
    {
        $config = \App\Models\Config::all()->last();
        return $config->semester_id;
    }

    public function getSemester($program_level_id)
    {
        return ProgramLevel::find($program_level_id)->program()->first()->background()->first()->currentSemesters()->first();
    }

    public static function instance()
    {
        return new Helpers();
    }

    function numToWord($number)
    {

        $hyphen      = '-';
        $conjunction = ' and ';
        $separator   = ', ';
        $negative    = 'negative ';
        $decimal     = ' point ';
        $dictionary  = array(
            0                   => 'zero',
            1                   => 'One',
            2                   => 'Two',
            3                   => 'Three',
            4                   => 'Four',
            5                   => 'Five',
            6                   => 'Six',
            7                   => 'Seven',
            8                   => 'Eight',
            9                   => 'Nine',
            10                  => 'Ten',
            11                  => 'Eleven',
            12                  => 'Twelve',
            13                  => 'Thirteen',
            14                  => 'Fourteen',
            15                  => 'Fifteen',
            16                  => 'Sixteen',
            17                  => 'Seventeen',
            18                  => 'Eighteen',
            19                  => 'Nineteen',
            20                  => 'Twenty',
            30                  => 'Thirty',
            40                  => 'Fourty',
            50                  => 'Fifty',
            60                  => 'Sixty',
            70                  => 'Seventy',
            80                  => 'Eighty',
            90                  => 'Ninety',
            100                 => 'Hundred',
            1000                => 'Thousand',
            1000000             => 'Million',
            1000000000          => 'Billion',
            1000000000000       => 'Trillion',
            1000000000000000    => 'Quadrillion',
            1000000000000000000 => 'Quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'numToWord only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . $this->numToWord(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . $this->numToWord($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = $this->numToWord($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $this->numToWord($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }

    public function getScore($seq_id, $subject_id, $class_id, $year, $student_id)
    {
        $result = Result::where([
            'student_id' => $student_id,
            'class_id' => $class_id,
            'sequence' => $seq_id,
            'subject_id' => $subject_id,
            'batch_id' => $year
        ])->first();

        if ($result) {
            return $result->score;
        }
    }

    public function getStudentScholarshipAmount($student_id)
    {
        //  $amount = 0;
        $amount = DB::table('student_scholarships')
            ->join('students', ['students.id' => 'student_scholarships.student_id'])
            ->where('student_scholarships.batch_id', $this->getCurrentAccademicYear())
            ->where('student_scholarships.student_id', $student_id)
            ->pluck('student_scholarships.amount')->first();
        if (empty($amount)) {
            $amount =  0;
        }
        return $amount;
    }


    public function getSchoolSubunitByParentId($parent_id)
    {
        $subunits = SchoolUnits::where('parent_id', $parent_id)->get();

        return $subunits;
    }

    public function nextAccademicYear($current_year = null)
    {
        # code...
        $year = $current_year == null ? $this->getCurrentAccademicYear() : $current_year;
        $years = Batch::all()->sortBy('name')->toArray();
        // $collection = collect($years)->where('id', '=', $year);
        $index = array_search(Batch::find($year), $years);
        $next_year = $index == false ? $year+1 : $index+1;
        return $next_year;
    }

    public function getHeader()
    {
        # code...
        return asset('assets/images/avatars/letterhead.jpg');
    }

    public function getBackground()
    {
        return url('/storage/app/bg_image/background_image.jpeg');
    }


    
    public function ca_total_isset($class_id)
    {
        # code...
        $class = ProgramLevel::find($class_id);
        $_isset = $class->program->ca_total != null || $class->program->ca_total != 0;
        return $_isset;
    }

    public function exam_total_isset($class_id)
    {
        # code...
        $class = ProgramLevel::find($class_id);
        $_isset = $class->program->exam_total != null || $class->program->exam_total != 0;
        return $_isset;
    }

    public function ca_total($class_id)
    {
        # code...
        $class = ProgramLevel::find($class_id);
        return $class->program->ca_total;
    }

    public function exam_total($class_id)
    {
        # code...
        $class = ProgramLevel::find($class_id);
        return $class->program->exam_total;
    }

    public function open_resits()
    {
        # code...
        $resits = Resit::whereDate('start_date', '<=', date('m/d/Y', time()))->whereDate('end_date', '>=', date('m/d/Y', time()))->get();
        return $resits;
    }

    public function resit_available($class_id, $campus_id = null)
    {
        # code...
        $class = ProgramLevel::find($class_id);
        $campus = $campus_id == null ? auth('student')->user()->campus_id : $campus_id;
        // dd($class);
        $resits = $class->program->background->resits()->where(['year_id' => Helpers::instance()->getCurrentAccademicYear(), 'campus_id'=>$campus, 'background_id'=>$class->program->background->id])->get();
        foreach ($resits as $key => $resit) {
            # code...
            if(now()->between(Carbon::createFromDate($resit->start_date), Carbon::createFromDate($resit->end_date)))
            return true;
        }
        return false;
    }

    public function available_resit($class_id, $campus_id = null)
    {
        # code...
        $class = ProgramLevel::find($class_id);
        $campus = $campus_id == null ? auth('student')->user()->campus_id : $campus_id;
        // dd($class);
        $resits = $class->program->background->resits()->where(['year_id' => Helpers::instance()->getCurrentAccademicYear(), 'campus_id'=>$campus, 'background_id'=>$class->program->background->id])->get();
        foreach ($resits as $key => $resit) {
            # code...
            if(now()->between(Carbon::createFromDate($resit->start_date), Carbon::createFromDate($resit->end_date)))
            return $resit;
        }
        return null;
    }

    public function has_paid_platform_charges($year_id = null)
    {
        # code...
        // if current student, he must have paid platform charges
        $year = $year_id == null ? $this->getCurrentAccademicYear() : $year_id;
        $current_class = auth('student')->user()->_class($year);
        $plcharge = PlatformCharge::where(['year_id'=>$year])->first();
        if($plcharge == null){return true;}
        if($current_class == null){
            // dd(auth()->user());
            // this is a former student; doesn't have to pay platform charges
            return true;
        }else{
            // check if student has payed platform charges
            if(Charge::where(['year_id'=>$year, 'student_id'=>auth('student')->id(), 'type'=>'PLATFORM'])->count() > 0){
                // student has paid platform charges
                return true;
            }
            return false;
        }
    }

    public function has_paid_result_charges($student_id, $semester_id, $year_id)
    {
        # code...
        $year = $year_id;
        // $class = Students::find($student_id)->_class();


        // check if student has payed result charges for the given accademic year
        if(Charge::where(['year_id'=>$year, 'student_id'=>$student_id, 'type'=>'RESULTS', 'semester_id'=>$semester_id])->count() > 0){
            // student has paid platform charges
            return true;
        }
        return false;
    }

    public function has_paid_transcript_charges($student_id, $semester_id, $year_id)
    {
        # code...
        $year = $year_id;
        // $class = Students::find($student_id)->_class();


        // check if student has payed result charges for the given accademic year
        if(Charge::where(['year_id'=>$year, 'student_id'=>$student_id, 'type'=>'RESULTS', 'semester_id'=>$semester_id])->count() > 0){
            // student has paid platform charges
            return true;
        }
        return false;
    }

    public function year_listing()
    {
        # code...
        $ac_year = Batch::find($this->getCurrentAccademicYear())->name;
        $year = (int)substr($ac_year, 0, 4);
        // dd($year);
        $years = [];
        for ($i=$year-20; $i < $year+10; $i++) { 
            # code...
            $years[] = $i;
        }
        return $years;
    }

    public function getApiRoot(){
        $api_root = File::where('name', 'api_root')->first();
        return $api_root == null ? null : $api_root->path;
    }

    public function application_open()
    {
        # code...
        $config = Config::where('year_id', Self::getCurrentAccademicYear())->first();
        return ($config != null) and (now()->isBetween(Carbon::parse($config->start_date), Carbon::parse($config->end_date)));
    }

}
