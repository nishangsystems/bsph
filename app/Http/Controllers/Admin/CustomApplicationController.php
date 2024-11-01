<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ApplicationForm;
use App\Models\Batch;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        $data['title'] = "Admit Foreign Students";
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
        return redirect(route('admin.applications.admit', $instance->id)."?foreign=1")->with('success', "Form sucessfully created.");
    }

    public function switch_program(Request $request){
        if($request->matric == null){
            $data['title'] = "Switch program for existing students";
            return view('admin.student.custom_applications.switch_index', $data);
        }
        try {
            //code...
            $student = $this->api_service->get_student_with_matric($request->matric);
            if($student == null){
                session()->flash('error', "Operation failed. Make sure you have an active data connection.");
                return back();
            }
            elseif($student->get('message') != null){
                session()->flash('error', $student->get('nessage'));
                return back();
            }
            $data['student'] = $student->get('student');
            $data['student_class'] = $student->get('student_class');
            $data['programs'] = collect(json_decode($this->api_service->programs())->data);
            $data['levels'] = collect(json_decode($this->api_service->levels())->data);
        $data['title'] = "Switch Program for {$data['student']['name']} [{$data['student']['matric']}]";
            // dd($data);
            return view('admin.student.custom_applications.switch', $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    
    public function switch_generate_matricule(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), ['matric'=>'required', 'program_id'=>'required', 'level'=>'required']);
        if($validator->fails()){
            session()->flash('error', "Operartion failed. ".$validator->errors()->first());
            return back();
        }

        $program = json_decode($this->api_service->programs($request->program_id))->data??null;
        if($program != null){
            try{
                $year = substr(Batch::find($this->current_accademic_year)->name, 2, 2);
                $prefix = $program->prefix;//3 char length
                $suffix = $program->suffix;//3 char length
                $max_count = '';
                if($prefix == null){
                    return back()->with('error', 'Matricule generation prefix not set.');
                }
                // dd($this->api_service->max_matric($prefix, $year, $suffix));
                $max_matric = json_decode($this->api_service->max_matric($prefix, $year, $suffix))->data??null; //matrics starting with '$prefix' sort
                if($max_matric == null){
                    $max_count = 0;
                }else{
                    $max_count = intval(substr($max_matric, -3));
                }
                NEXT_MATRIC:
                $next_count = substr('000'.(++$max_count), -3);
                $suffix = $suffix.$request->foreigner??'';
                $student_matric = $prefix.$year.$suffix.$next_count;
                // dd($student_matric);
                
                // dd(ApplicationForm::where('matric', $student_matric)->get());
                if(ApplicationForm::where('matric', $student_matric)->count() == 0){
                    $student = $this->api_service->get_student_with_matric($request->matric);
                    $data['title'] = "Change Student Program";
                    $data['student'] = $student->get('student');
                    $data['student_class'] = $student->get('student_class');
                    $data['new_program'] = $program;
                    $data['old_program'] = json_decode($this->api_service->programs($data['student_class']['program_id']))->data??null;
                    $data['matricule'] = $student_matric;
                    $data['old_level'] = optional(collect(json_decode($this->api_service->levels())->data)->where('id', $data['student_class']['level_id'])->first())->level??'';
                    $data['new_level'] = $request->level;
                    $data['campus'] = $student->get('student')['campus_id'];
                    // dd($data);
                    return view('admin.student.custom_applications.confirm_switch', $data);
                }else{
                    goto NEXT_MATRIC;
                    $student = ApplicationForm::where('matric', $student_matric)->first();
                    return back()->with('error', "Student With name ".($student->name??'').". already has matricule {$student_matric} on this application portal.");
                }
            }catch(\Throwable $th){
                return back()->with('error', 'Failed to generate matricule. '.$th->getMessage());
            }
        }
    }

    public function switch_confirmed(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), ['old_matric'=>'required', 'program_id'=>'required', 'level'=>'required', 'matric'=>'required']);
        if($validator->fails()){
            session()->flash('error', "Operation failed. ".$validator->errors()->first());
            return back();
        }

        $resp = json_decode($this->api_service->update_student($request->old_matric, ['program'=>$request->program_id, 'level'=>$request->level, 'year_id'=>$this->current_accademic_year, 'matric'=>$request->matric]))->data??null;
        // dd($resp);

        if(is_string($resp)){
            session()->flash('error', "Operation failed. ".$resp??'');
            return redirect(route('admin.custom_applications.index'));
        }
        $program = json_decode($this->api_service->programs($request->program_id))->data;
        if($resp->status == 1){
            $student_data = [
                'name'=>$resp->student->name,
                'email'=>$resp->student->email,
                'phone'=>$resp->student->phone,
                'address'=>$resp->student->address,
                'gender'=>$resp->student->gender,
                'password'=>Hash::make('12345678'),
                'active'=>1
            ];

        // dd($resp->student);
        $std = Students::create($student_data);

            $form_data = [
                'student_id'=>$std->id, 'year_id'=>$this->current_accademic_year, 'gender'=>$resp->student->gender, 'name'=>$resp->student->name, 'dob'=>$resp->student->dob, 'pob'=>$resp->student->pob, 
                'nationality'=>$resp->student->nationality, 'region'=>$resp->student->region, 'division'=>$resp->student->division, 'residence'=>$resp->student->address, 'phone'=>$resp->student->phone, 
                'email'=>$resp->student->email, 'program_first_choice'=>$request->program_id, 'special_needs'=>$resp->student->special_needs??null, 'father_name'=>$resp->student->father_name, 
                'father_address'=>$resp->student->father_address, 'father_tel'=>$resp->student->father_tel, 'mother_name'=>$resp->student->mother_name, 
                'mother_address'=>$resp->student->mother_address, 'mother_tel'=>$resp->student->mother_tel, 'guardian_name'=>$resp->student->guardian_name, 'guardian_address'=>$resp->student->guardian_address, 
                'guardian_tel'=>$resp->student->guardian_tel, 'matric'=>$request->matric, 'campus_id'=>$resp->student->campus_id, 'degree_id'=>$program->degree_id, 'transaction_id'=>-10000, 'admitted'=>1,
                'emergency_name'=>$resp->student->emergency_name, 'emergency_address'=>$resp->student->emergency_address, 'emergency_tel'=>$resp->student->emergency_tel, 
                'level'=>$request->level, 'bypass_reason'=>"Former student switched program.", 'admitted_at'=>now()
            ];
            $form = new ApplicationForm($form_data);
            $form->save();
            return redirect(route('admin.custom_applications.index'))->with('success', "Operation complete.");
        }
        session()->flash('error', "Operation failed. ".$resp??'');
        return redirect(route('admin.custom_applications.index'));
    }



    // Manage Student Importation

    public function import_admit_students(Request $request){
        $data['title'] = "Import Students Into Main School System";
        $data['degrees'] = collect(json_decode($this->api_service->degrees())->data);
        return view('admin.student.custom_applications.import_students', $data);
    }

    public function import_admit_students_save(Request $request){
        // dd($request->all());
        $validity = Validator::make($request->all(), [
            'batch'=>'required', 
            'degree_id'=>'required', 
            'program_first_choice'=>'required', 
            'level'=>'required', 
            'file'=>'file|required|mimes:csv', 
            'campus_id'=>'required'
        ]);
        if ($validity->fails()) {
            # code...
            session()->flash('error', $validity->errors()->first());
            return back()->withInput()->with($validity->errors());
        }

        try{

            $file = $request->file('file');
            $fname = 'students_to_import.csv';
            $path = public_path('uploads/files');
            $file->storeAs('files', $fname, ['disk'=>'public_uploads']);
    
            $fstream = fopen($path.'/'.$fname, 'r');
            $data = [];
            $form_data = [];
            $errors = '';
            $program = json_decode($this->api_service->programs($request->program_first_choice))->data;
            while(($row = fgetcsv($fstream, 1000, ',')) != null){
                // student data instance for admission
                $data[] = collect([
                    'name'=>$row[0], 
                    'matric'=>$row[1], 
                    'gender'=>array_key_exists(2, $row) ? $row[2] : null,
                    'dob'=>array_key_exists(4, $row) ? $row[4] : null, 
                    'pob'=>array_key_exists(3, $row) ? $row[3] : null,
                    'year_id'=>$request->batch??null,
                    'campus_id'=>$request->campus_id??null, 
                    'admission_batch_id'=>$request->batch??null,
                    'fee_payer_name'=>$request->fee_payer_name??null, 
                    'program_first_choice'=>$request->program_first_choice??null, 
                    'region'=>$request->region??null,
                    'fee_payer_tel'=>$request->fee_payer_tel??null, 
                    'division'=>$request->division??null,
                    'level'=>$request->level??null
                ]);
    
                // application portal student and application form instances
                $form_data[$row[1]] = [
                        'student' => [
                            'name'=>$row[0],
                            'email'=>'.',
                            'phone'=>array_key_exists(5, $row) ? $row[5] : $row[1],
                            'address'=>'.',
                            'gender'=>array_key_exists(2, $row) ? $row[2] : '.',
                            'password'=>Hash::make('12345678'),
                            'active'=>1
                        ],
                        'form' => [
                            'year_id'=>$request->batch, 
                            'gender'=>(array_key_exists(2, $row) ? $row[2] : '.'), 
                            'name'=>$row[0], 
                            'dob'=>(array_key_exists(4, $row) ? $row[4] : null), 
                            'pob'=>(array_key_exists(3, $row) ? $row[3] : null), 
                            'nationality'=>'.', 'region'=>'.', 'division'=>'.', 'residence'=>'.', 'phone'=>'.', 
                            'email'=>'.', 'program_first_choice'=>$request->program_first_choice??null,
                            'matric'=>$row[1], 'campus_id'=>$request->campus_id??null, 
                            'degree_id'=>$program->degree_id, 'transaction_id'=>-10000, 'admitted'=>1,
                            'level'=>$request->level, 'bypass_reason'=>"imported student record", 'admitted_at'=>now()
                        ]
                    ];
            }
    
            $platform_data = [];
            // dd($form_data);
            if(count($data) > 0){
                try {
                    $response = $this->api_service->export_students($data);
                    $matrics = array_values((array)optional($response['data']['matrics']));
                    // dd($matrics);
                    if($matrics != null){
                        foreach ($matrics[0] as $value) {
                            // dd($value);
                            // dd($record = $form_data[$value]);
                            if(($record = $form_data[$value]) != null){
                                if(($stud = Students::where(['name'=>$record['student']['name'], 'phone'=>$record['student']['phone']])->first()) == null)
                                    $stud = Students::create(['name'=>$record['student']['name'], 'phone'=>$record['student']['phone']], $record['student']);
                                $form = $record['form'];
                                $form['student_id'] = $stud->id;
                                if(($aplf = ApplicationForm::where(['matric'=>$form['matric'], 'student_id'=>$form['student_id'], 'year_id'=>$form['year_id'], 'name'=>$form['name']])->first()) == null)
                                    $aplf = ApplicationForm::create($form);
                                else
                                    $aplf->update($form);
                                $platform_data[] = ['student'=>$stud, 'form'=>$aplf];
                            }
                        }
                    }
                    //code...
                } catch (\Throwable $th) {
                    //throw $th;
                    $errors .= $th->getMessage();
                }
            }
            // dd($platform_data);
            if(strlen($errors) > 0){
                session()->flash('error', $errors);
            }
            return back()->with('success', "Done");
        }catch(\Throwable $th){
            session()->flash('error', $th->getMessage());
            return back();
        }
    }
}
