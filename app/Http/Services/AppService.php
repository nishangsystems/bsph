<?php
namespace App\Http\Services;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Http;
use App\Http\Services\ApiService;
use App\Models\AdmissionLetterPage2;
use App\Models\ApplicationForm;
use App\Models\Config;
use App\Models\ProgramAdmin;
use Barryvdh\DomPDF\Facade\Pdf;

class AppService{

    protected $api_service;
    public function __construct(ApiService $apiServce) {
        $this->api_service = $apiServce;
    }

    public function admission_letter($appl_id)
    {
        # code...
        $appl = ApplicationForm::find($appl_id);
        // dd($appl);
        if($appl != null){
            $programs = collect(json_decode($this->api_service->programs())->data);
            $campus = collect(json_decode($this->api_service->campuses())->data)->where('id', $appl->campus_id)->first()??null;
            $program = $programs->where('id', $appl->program_first_choice)->first()??null;
            $department = $programs->where('id', $program->parent_id)->first()??null;
            $degree = collect(json_decode($this->api_service->degrees())->data)->where('id', $appl->degree_id)->first()??null;
            $config = Config::where('year_id', Helpers::instance()->getCurrentAccademicYear())->first();
            $data['appl'] = $appl;
            $data['year'] = substr($appl->year->name, -4);
            $data['_year'] = substr($appl->year->name, 2, 2);
            // dd($data);
            $data['title'] = "ADMISSION LETTER";
            $data['filters'] = collect([
                ['program'=>178, 'duration'=>4, 'mentor'=>'University of Buea'],
                ['program'=>179, 'duration'=>3, 'mentor'=>'University of Buea'],
                ['program'=>170, 'duration'=>3, 'mentor'=>'University of Buea'],
                ['program'=>173, 'duration'=>4, 'mentor'=>'University of Dschang'],
                ['program'=>167, 'duration'=>4, 'mentor'=>'University of Ngoundere'],
                ['program'=>172, 'duration'=>3, 'mentor'=>'University of Zimbabwe'],
                ['program'=>164, 'duration'=>3, 'mentor'=>'MINSUP'],
                ['program'=>168, 'duration'=>3, 'mentor'=>'MINSUP'],
                ['program'=>161, 'duration'=>3, 'mentor'=>'MINSUP'],
                ['program'=>174, 'duration'=>2, 'mentor'=>'Baptist School of Public Health'],
                ['program'=>175, 'duration'=>2, 'mentor'=>'Baptist School of Public Health'],
            ]);
            $data['name'] = $appl->name;
            $data['matric'] =  $appl->matric;
            $data['auth_no'] =  time().'/'.random_int(150553, 998545).'R'.$program->id.'BSPH'.$appl_id;
            $data['help_email'] =  $config->help_email;
            $data['campus'] = $campus->name??null;
            $data['degree'] = ($program->deg_name??null) == null ? ("NOT SET") : $program->deg_name;
            $data['_degree'] = $degree;
            $data['program'] = str_replace($degree->deg_name??'', ' ', $program->name??"");
            $data['_program'] = $program;
            $data['matric_sn'] = substr($appl->matric, -3);
            $data['department'] = $department->name??'-------';
            $data['start_of_lectures'] = Config::where('year_id', Helpers::instance()->getCurrentAccademicYear())->first()->start_of_lectures?->format('F dS Y');
            // dd($program);
            if($data['degree'] ==  null){
                session()->flash('error', 'Program Degree Name not set');
                return back()->withInput();
            }
            // dd($data);
            // return view('admin.student.admission_letter', $data);
            $pdf = Pdf::loadView('admin.student.admission_letter', $data);
            return $pdf->download($appl->matric.'_ADMISSION_LETTER.pdf');            
        }
    }

    public function application_form($application_id){
        $application = ApplicationForm::find($application_id);
        $data['campuses'] = json_decode($this->api_service->campuses())->data;
        $data['application'] = ApplicationForm::find($application_id);
        $data['degree'] = collect(json_decode($this->api_service->degrees())->data??[])->where('id', $data['application']->degree_id)->first();
        $data['campus'] = collect($data['campuses'])->where('id', $data['application']->campus_id)->first();
        $data['certs'] = json_decode($this->api_service->certificates())->data;
        
        // $data['programs'] = json_decode($this->api_service->campusDegreeCertificatePrograms($data['application']->campus_id, $data['application']->degree_id, $data['application']->entry_qualification))->data;
        $data['programs'] = json_decode($this->api_service->programs())->data;
        $data['cert'] = collect($data['certs'])->where('id', $data['application']->entry_qualification)->first();
        $data['program1'] = collect($data['programs'])->where('id', $data['application']->program_first_choice)->first();
        $data['program2'] = collect($data['programs'])->where('id', $data['application']->program_second_choice)->first();
        $data['program3'] = collect($data['programs'])->where('id', $data['application']->program_third_choice)->first();
        
        $title = "APPLICATION FORM INTO BAPTIST SCHOOL OF PUBLIC HEALTH (BSPH)";
        // $title = __('text.inst_tapplication_form', ['degree'=>$data['degree']->deg_name]);
        $data['title'] = $title;
        $data['lhead'] = 0;

        $data['ol_results'] = json_decode($application->ol_results);
        $data['al_results'] = json_decode($application->al_results);
        $data['result_count'] = ($ol_count = count($data['ol_results']? $data['ol_results'] : [])) > ($al_count = count($data['al_results'] ? $data['al_results'] : [])) ? $ol_count : $al_count; 
        // dd($data);
        // if(in_array(null, array_values($data))){ return redirect(route('student.application.start', [0, $application_id]))->with('message', "Make sure your form is correctly filled and try again.");}
        // return view('student.online.form_dawnloadable', $data);
        $pdf = PDF::loadView('student.online.form_dawnloadable', $data);
        $filename = $title.' - '.$application->name.'.pdf';
        return $pdf->download($filename);
    }
}