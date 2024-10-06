<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ApplicationForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomApplicationController extends Controller
{
    //ALL CUSTOM APPLICATIONS ARE ALL AUTO-SUBMITTED ON CREATEION, WITH A TRANSACTION ID OF -10000 

    public function index(){
        $programs = collect(json_decode($this->api_service->programs())->data);
        $data['title'] = "All Custom Applications";
        $data['applications'] = ApplicationForm::where(['transaction_id'=>-10000])->orderBy('name')->get()->each(function($rec)use($programs){
            $rec->program_name = ($prog = $programs->where('id', $rec->program_first_choice)->first()) == null ? '----' : $prog->name;
        });
        return view('admin.student.custom_applications.index', $data);
    }

    public function create(){
        $degrees = collect(json_decode($this->api_service->degrees())->data);
        $data['title'] = "All Custom Applications";
        $data['degrees'] = $degrees;
        return view('admin.student.custom_applications.create', $data);
    }

    public function store(Request $request){
        $validity = Validator::make($request->all(), ['name'=>'required', 'gender'=>'required', 'phone'=>'required', 'degree_id'=>'required', 'program_first_choice'=>'required', 'level'=>'required']);
        if($validity->fails()){
            session()->flash('error', $validity->errors()->first());
            return back();
        }

        $data = $request->all();
        $data['transaction_id'] = -10000;
        $data['submitted'] = 1;
        $data['year_id'] = $this->current_accademic_year;
        if(ApplicationForm::where(['name'=>$data['name'], 'phone'=>$data['phone'], 'year_id'=>$this->current_accademic_year])->count() > 0){
            session()->flash('error', "Application form with same and phone number already exists for the current accademic year");
            return back();
        }
        $instance = ApplicationForm::create($data);
        return redirect(route('admin.applications.admit', $instance->id))->with('success', "Form sucessfully created.");
    }
}
