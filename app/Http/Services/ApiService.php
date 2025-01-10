<?php
namespace App\Http\Services;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Http;

class ApiService{

    
    // get campuses
    public function campuses(){
        return Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.campuses'))->body();
    }

    // get campuses
    public function campusDegrees($campus_id){
        return Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.campus_degrees').'/'.$campus_id)->body();
    }

    // get campuses
    public function campusProgramLevels($campus_id, $program_id){
        return Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.campus_program_levels').'/'.$campus_id.'/'.$program_id)->body();
    }

    // get campuses
    public function setCertificatePrograms($certificate_id, array $program_ids){
        return Http::post(Helpers::instance()->getApiRoot().'/'.config('api_routes.certificate_programs').'/'.$certificate_id, ['certificate_id'=>$certificate_id, 'program_ids'=>$program_ids])->body();
    }

    // Store/update admitted student
    public function store_student($student,  $id= null){
        return Http::contentType('application/json')->post(Helpers::instance()->getApiRoot().'/'.config('api_routes.store_student'), ['student'=>json_encode($student, 1)])->body();
    }

    // Store/update admitted student
    public function update_student($matric, $update){ return Http::contentType('application/json')->get(Helpers::instance()->getApiRoot().'/'.config('api_routes.update_student') .'?matric='.json_encode($matric).'&student='.json_encode($update) )->body();
    }

    // get campuses
    public function certificatePrograms($certificate_id){
        return Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.certificate_programs').'/'.$certificate_id)->body();
    }

    // get campuses
    public function certificates(){
        return Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.certificates'))->body();
    }

    // get campuses
    public function degrees(){
         return Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.degrees'))->body();
    }

    // get campuses
    public function campusDegreeCertificatePrograms($campus_id, $degree_id, $certificate_id){
        return Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.campus_degree_certificate_programs').'/'.$campus_id.'/'.$degree_id.'/'.$certificate_id)->body();
    }

    public function programs($program_id = null)
    {
        # code...
        return Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.programs').'/'.$program_id)->body();
    }


    public function campusPrograms($campus_id){
        return Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.campus_programs').'/'.$campus_id)->body();
    }


    public function campusProgramsBySchool($campus_id){
        return Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.campus_programs_by_school').'/'.$campus_id)->body();
    }

    public function setCampusDegrees($campus_id, $degrees)
    {
        # code...
        return Http::post(Helpers::instance()->getApiRoot().'/'.config('api_routes.campus_degrees').'/'.$campus_id, ['degrees'=>$degrees])->body();
    }

    public function levels()
    {
        # code...
        return Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.levels'))->body();
    }

    public function max_matric($prefix, $year, $suffix=null)
    {
        # code...
        return Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.max_matric').'/'.$prefix.'/'.$year.'/'.$suffix)->body();
    }

    public function matric_exist($matric)
    {
        # code...
        return Http::post(Helpers::instance()->getApiRoot().'/'.config('api_routes.matric_exist'), ['matric'=>$matric])->body();
    }

    public function degree_certificates($degree_id){
        return Http::get(Helpers::instance()->getApiRoot().'/degree/certificates/'.$degree_id)->body();
    }
    
    public function set_degree_certificates($degree_id, array $certificate_ids){
        return Http::post(Helpers::instance()->getApiRoot().'/degree/certificates/'.$degree_id, ['certificates'=>$certificate_ids])->body();
    }

    public function portal_fee_structure($year_id = null){
        return Http::get(Helpers::instance()->getApiRoot()."/portal_fee_structure/{$year_id}")->collect();
    }

    public function class_portal_fee_structure($program, $level, $year_id = null, $option=null){
        return Http::get(Helpers::instance()->getApiRoot()."/class_portal_fee_structure/{$program}/{$level}/{$year_id}?option={$option}")->collect();
    }

    public function school_program_structure()
    {
        # code...
        return Http::get(Helpers::instance()->getApiRoot()."/school_program_structure")->collect();

    }
    
    public function set_appliable_programs($programs)
    {
        # code...
        return Http::post(Helpers::instance()->getApiRoot()."/appliable_programs/set", ['programs'=>$programs])->collect();
    }
    
    public function get_student_with_matric($matric){
        return Http::get(Helpers::instance()->getApiRoot()."/get_student_with_matric", ['matric'=>$matric])->collect();
    }

    public function export_students($data){
        return Http::post(Helpers::instance()->getApiRoot()."/portal_import_students", ['data'=>$data])->collect();
    }
}