<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Services\ApiService;
use App\Models\ApplicationForm;
use App\Models\Batch;
use App\Models\Campus;
use App\Models\Level;
use App\Models\ProgramLevel;
use App\Models\SchoolUnits;
use App\Models\Students;
use Carbon\Carbon;
use DateTime;
use Doctrine\DBAL\Types\TimeType;
use FontLib\Table\Type\name;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Type\Time;
use Throwable;

class StatisticsController extends Controller
{
    protected $apiService;
    protected $current_year;
    public function __construct(ApiService $service)
    {
        $this->apiService = $service;
        $this->current_year = Helpers::instance()->getCurrentAccademicYear();
    }
    
    //
    public function application_stats(Request $request){

        $validator = Validator::make([$request->all()], ['filter'=>'in:program,degree|nullable']);
        if($validator->fails()){
            session()->flash('error', $validator->errors()->first());
        }
        $programs = collect(json_decode($this->apiService->programs())->data);
        $degrees = collect(json_decode($this->apiService->degrees())->data);
        switch($request->filter){
            case 'degree':
                $data['title'] = "Application Statistics Filtered By Degree";
                $forms = ApplicationForm::where(['year_id'=>$this->current_year, 'submitted'=> 1])->where('transaction_id', '!=', -10000)->groupBy('degree_id')
                ->select(['degree_id', DB::raw("COUNT(*) as _count"), DB::raw("SUM(CASE gender WHEN 'male' THEN 1 ELSE 0 END) as male_count"), DB::raw("SUM(CASE gender WHEN 'female' THEN 1 ELSE 0 END) as female_count")])
                ->having('_count', '>', 0)->distinct()->get()->each(function($rec)use($degrees){
                    $rec->degree = $degrees->where('id', $rec->degree_id)->first()->deg_name??null;
                    $rec->amount = $degrees->where('id', $rec->degree_id)->first()->amount??null;
                    $rec->total = intval($rec->amount) * $rec->_count;
                });
                $data['forms'] = $forms;
                break;
                
            default:
                $data['title'] = "Application Statistics Filtered By Program";
                $forms = ApplicationForm::where(['year_id'=>$this->current_year, 'submitted'=> 1])->where('transaction_id', '!=', -10000)->groupBy('program_first_choice')
                    ->select(['program_first_choice', DB::raw("COUNT(*) as _count"), DB::raw("SUM(CASE gender WHEN 'male' THEN 1 ELSE 0 END) as male_count"), DB::raw("SUM(CASE gender WHEN 'female' THEN 1 ELSE 0 END) as female_count")])
                    ->having('_count', '>', 0)->distinct()->get()->each(function($rec)use($programs, $degrees){
                        $program = $programs->where('id', $rec->program_first_choice)->first();
                        $degree = $degrees->where('id', optional($program)->degree_id??null)->first();
                        $rec->program = optional($program)->name??null;
                        $rec->amount = ($degree)->amount??null;
                        $rec->total = intval($rec->amount) * $rec->_count;
                    });
                $data['forms'] = $forms;
                break;
        }
        // dd($data);
        return view('admin.statistics.applications', $data);
        
    }

    //
    public function admission_stats(Request $request){
        $validator = Validator::make([$request->all()], ['filter'=>'in:program,degree|nullable']);
        if($validator->fails()){
            session()->flash('error', $validator->errors()->first());
        }
        $programs = collect(json_decode($this->apiService->programs())->data);
        $degrees = collect(json_decode($this->apiService->degrees())->data);
        switch($request->filter){
            case 'degree':
                $data['title'] = "Admission Statistics Filtered By Degree";
                $forms = ApplicationForm::where(['year_id'=>$this->current_year, 'submitted'=> 1, 'admitted'=>1])->where('transaction_id', '!=', -10000)->whereNotNull('matric')->groupBy('degree_id')
                ->select(['degree_id', DB::raw("COUNT(*) as _count"), DB::raw("SUM(CASE gender WHEN 'male' THEN 1 ELSE 0 END) as male_count"), DB::raw("SUM(CASE gender WHEN 'female' THEN 1 ELSE 0 END) as female_count")])
                ->having('_count', '>', 0)->distinct()->get()->each(function($rec)use($degrees){
                    $rec->degree = $degrees->where('id', $rec->degree_id)->first()->deg_name??null;
                });
                $data['forms'] = $forms;
                break;
                
                default:
                $data['title'] = "Admission Statistics Filtered By Program";
                $forms = ApplicationForm::where(['year_id'=>$this->current_year, 'submitted'=> 1, 'admitted'=>1])->where('transaction_id', '!=', -10000)->whereNotNull('matric')->groupBy('program_first_choice')
                    ->select(['program_first_choice', DB::raw("COUNT(*) as _count"), DB::raw("SUM(CASE gender WHEN 'male' THEN 1 ELSE 0 END) as male_count"), DB::raw("SUM(CASE gender WHEN 'female' THEN 1 ELSE 0 END) as female_count")])
                    ->having('_count', '>', 0)->distinct()->get()->each(function($rec)use($programs){
                        $rec->program = $programs->where('id', $rec->program_first_choice)->first()->name??null;
                    });
                $data['forms'] = $forms;
                break;
        }
        return view('admin.statistics.admissions', $data);
    }

    //
    public function fee_bypass_stats(Request $request){
        $validator = Validator::make([$request->all()], ['filter'=>'in:program,degree|nullable']);
        if($validator->fails()){
            session()->flash('error', $validator->errors()->first());
        }
        $programs = collect(json_decode($this->apiService->programs())->data);
        $degrees = collect(json_decode($this->apiService->degrees())->data);
        switch($request->filter){
            case 'degree':
                $data['title'] = "Application Fee Bypass Statistics Filtered By Degree";
                $forms = ApplicationForm::where(['year_id'=>$this->current_year])->whereNotNull('transaction_id')->where('transaction_id', '!=', -10000)->whereNotNull('bypass_reason')->groupBy('degree_id')
                ->select(['degree_id', DB::raw("COUNT(*) as _count")])
                ->having('_count', '>', 0)->distinct()->get()->each(function($rec)use($degrees){
                    $rec->degree = $degrees->where('id', $rec->degree_id)->first()->deg_name??null;
                });
                $data['forms'] = $forms;
                break;
                
                default:
                $data['title'] = "Application Fee Bypass Statistics Filtered By Program";
                $forms = ApplicationForm::where(['year_id'=>$this->current_year])->whereNotNull('transaction_id')->where('transaction_id', '!=', -10000)->whereNotNull('bypass_reason')->groupBy('program_first_choice')
                    ->select(['program_first_choice', DB::raw("COUNT(*) as _count")])
                    ->having('_count', '>', 0)->distinct()->get()->each(function($rec)use($programs){
                        $rec->program = $programs->where('id', $rec->program_first_choice)->first()->name??null;
                    });
                $data['forms'] = $forms;
                break;
        }
        // dd($data);
        return view('admin.statistics.bypass', $data);
    }
}
