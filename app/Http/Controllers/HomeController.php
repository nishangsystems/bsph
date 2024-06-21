<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Http\Resources\Fee;
use App\Http\Resources\StudentResource3;
use App\Http\Resources\StudentRank;
use App\Http\Resources\CollectBoardingFeeResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\SchoolUnitResource;
use App\Http\Resources\StudentFee;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentResourceMain;
use App\Models\Color;
use Illuminate\Support\Facades\Auth;
use Throwable;
use \PDF;

class HomeController extends Controller
{

    private $select = [
        'students.id as id',
        'students.name',
        'student_classes.year_id',
    ];
    private $select1 = [];
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return redirect()->to(route('login'));
    }


    public function student($name)
    {
        $students = \App\Models\Students::join('student_classes', ['students.id' => 'student_classes.student_id'])
            ->join('campuses', ['students.campus_id' => 'campuses.id'])
            ->where('student_classes.year_id', \App\Helpers\Helpers::instance()->getYear())
            ->join('program_levels', ['students.program_id' => 'program_levels.id'])
            ->join('school_units', ['program_levels.program_id' => 'school_units.id'])
            ->join('levels', ['program_levels.level_id' => 'levels.id'])
            ->where('students.name', 'LIKE', "%{$name}%")
            ->orWhere('students.matric', '=', $name)
            ->take(10)
            ->get(['students.*', 'campuses.name as campus']);

        return \response()->json(StudentFee::collection($students));
    }

    public function student_get()
    {
        $name = request('name');
        $students = \App\Models\Students::join('student_classes', ['student_classes.student_id' => 'students.id'])
            ->join('campuses', ['students.campus_id' => 'campuses.id'])
            ->where('student_classes.year_id', \App\Helpers\Helpers::instance()->getYear())
            ->join('program_levels', ['student_classes.class_id' => 'program_levels.id'])
            ->join('school_units', ['program_levels.program_id' => 'school_units.id'])
            ->join('levels', ['program_levels.level_id' => 'levels.id'])
            ->where(function($query)use($name){
                $query->where('students.name', 'LIKE', "%{$name}%")
                ->orWhere('students.matric', 'LIKE', "%{$name}%");
            })
            ->where(function($query){
                \auth()->user()->campus_id != null ? $query->where('students.campus_id', '=', \auth()->user()->campus_id) : null;
                        })
            ->take(10)->get(['students.*', 'campuses.name as campus']);

            // return $students;
        return \response()->json(StudentFee::collection($students));
    }

    public function searchStudents($name)
    {
        $name = str_replace('/', '\/', $name);
        try {
            //code...
            // $sql = "SELECT students.*, student_classes.student_id, student_classes.class_id, campuses.name as campus from students, student_classes, campuses where students.id = student_classes.student_id and students.campus_id = campuses.id and students.name like '%{$name}%' or students.matric like '%{$name}%'";

            // return DB::select($sql);
            $students  = DB::table('students')
                ->join('student_classes', ['students.id' => 'student_classes.student_id'])
                ->join('campuses', ['students.campus_id'=>'campuses.id'])
                ->where('students.name', 'LIKE', "%$name%")
                ->orWhere('students.matric', 'LIKE', "%$name%")->distinct()->take(10)
                ->get(['students.*', 'student_classes.student_id', 'student_classes.class_id', 'campuses.name as campus'])->toArray();
            return \response()->json(StudentResource3::collection($students));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function searchStudents_get()
    {
        $name = request('key');
        // return $name;
        $name = str_replace('/', '\/', $name);
        try {
            //code...
            // $sql = "SELECT students.*, student_classes.student_id, student_classes.class_id, campuses.name as campus from students, student_classes, campuses where students.id = student_classes.student_id and students.campus_id = campuses.id and students.name like '%{$name}%' or students.matric like '%{$name}%'";

            // return DB::select($sql);
            $students  = DB::table('students')
                ->join('student_classes', ['students.id' => 'student_classes.student_id'])
                ->join('campuses', ['students.campus_id'=>'campuses.id'])
                ->where(function($query)use($name){
                    $query->where('students.name', 'LIKE', "%$name%")
                    ->orWhere('students.matric', 'LIKE', "%$name%");
                })
                ->where(function($query){
                    \auth()->user()->campus_id != null ? $query->where('students.campus_id', '=', \auth()->user()->campus_id) : null;
                })
                ->distinct()
                ->take(10)
                ->get(['students.*', 'student_classes.student_id', 'campuses.name as campus'])
                ->toArray();
            
            return \response()->json(StudentResource3::collection($students));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function search_students()
    {
        $name = request('key');
        // return $name;
        try {
            //code...
            $students  = \App\Models\Students::where(function($query)use($name){
                    $query->where('students.name', 'LIKE', "%$name%")
                    ->orWhere('students.phone', 'LIKE', "%$name%");
                })
                ->distinct()->take(10)
                ->get(['students.*'])
                ->toArray();
            
            return response()->json(StudentResourceMain::collection($students));
        } catch (\Throwable $th) {
            return $th->getTrace();
        }
    }


    public static function getColor($label)
    {
        # code...
        $color = Color::where(['name'=>$label])->first();
        return $color == null ? null : $color->value;
    }
    
}
