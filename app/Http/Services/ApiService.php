<?php
namespace App\Http\Services;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Http;

class ApiService{

    
    // get campuses
    public function campuses(){

        // static data for a campus since current system has just one campus
        // return json_encode(['data'=>[['id'=>1, 'name'=>'BIAKA UNIVERSITY CAMPUS', 'address'=>'MOLYKO, BUEA, SWR-CAMEROON', 'telephone'=>'679135426', 'school_id'=>'1']]]);

        // dd(Helpers::instance()->getApiRoot().'/'.config('api_routes.campuses'));
        return Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.campuses'))->body();
    }

    // get campuses
    public function campusDegrees($campus_id){
        // dd([ Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.campus_degrees').'/'.$campus_id)->body(), Helpers::instance()->getApiRoot().'/'.config('api_routes.campus_degrees').'/'.$campus_id]);
        return Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.campus_degrees').'/'.$campus_id)->body();
    }

    // get campuses
    public function campusProgramLevels($campus_id, $program_id){
        // dd([ Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.campus_program_levels').'/'.$campus_id.'/'.$program_id)->body(), Helpers::instance()->getApiRoot().'/'.config('api_routes.campus_program_levels').'/'.$campus_id.'/'.$program_id]);
        return Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.campus_program_levels').'/'.$campus_id.'/'.$program_id)->body();
    }

    // get campuses
    public function setCertificatePrograms($certificate_id, array $program_ids){
        // dd([ Http::post(Helpers::instance()->getApiRoot().'/'.config('api_routes.certificate_programs').'/'.$certificate_id, ['certificate_id'=>$certificate_id, 'program_ids'=>$program_ids])->body(), Helpers::instance()->getApiRoot().'/'.config('api_routes.certificate_programs').'/'.$certificate_id]);
        return Http::post(Helpers::instance()->getApiRoot().'/'.config('api_routes.certificate_programs').'/'.$certificate_id, ['certificate_id'=>$certificate_id, 'program_ids'=>$program_ids])->body();
    }

    // Store/update admitted student
    public function store_student($student,  $id= null){
        // dd(Helpers::instance()->getApiRoot().'/'.config('api_routes.store_student'));
        return Http::contentType('application/json')->post(Helpers::instance()->getApiRoot().'/'.config('api_routes.store_student'), ['student'=>json_encode($student, 1)])->body();
        // return Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.store_student') .'?student='.json_encode($student) )->body();
    }

    // Store/update admitted student
    public function update_student($matric, $update){
        // dd([ Http::post(Helpers::instance()->getApiRoot().'/'.config('api_routes.store_student').'/'.$id??null, ['student'=>$student])->body(), Helpers::instance()->getApiRoot().'/'.config('api_routes.store_student').'/'.$id??null]);
        // dd([Http::contentType('application/json')->get(Helpers::instance()->getApiRoot().'/'.config('api_routes.update_student') .'?matric='.json_encode($matric).'&student='.json_encode($update) )->body(), Helpers::instance()->getApiRoot().'/'.config('api_routes.update_student') .'?matric='.json_encode($matric).'&student='.json_encode($update)]);
        return Http::contentType('application/json')->get(Helpers::instance()->getApiRoot().'/'.config('api_routes.update_student') .'?matric='.json_encode($matric).'&student='.json_encode($update) )->body();
    }

    // get campuses
    public function certificatePrograms($certificate_id){
        // dd([ Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.certificate_programs').'/'.$certificate_id)->body(), Helpers::instance()->getApiRoot().'/'.config('api_routes.certificate_programs').'/'.$certificate_id]);
        return Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.certificate_programs').'/'.$certificate_id)->body();
    }

    // get campuses
    public function certificates(){
        // dd([ Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.certificates'))->body(), Helpers::instance()->getApiRoot().'/'.config('api_routes.certificates')]);
        return Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.certificates'))->body();
    }

    // get campuses
    public function degrees(){
        // dd([ Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.degrees'))->body(), Helpers::instance()->getApiRoot().'/'.config('api_routes.degrees')]);
        return Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.degrees'))->body();
    }

    // get campuses
    public function campusDegreeCertificatePrograms($campus_id, $degree_id, $certificate_id){
        // dd(Helpers::instance()->getApiRoot().'/'.config('api_routes.campus_degree_certificate_programs').'/'.$campus_id.'/'.$degree_id.'/'.$certificate_id);
        // dd(Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.campus_degree_certificate_programs').'/'.$campus_id.'/'.$degree_id.'/'.$certificate_id)->collect());
        return Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.campus_degree_certificate_programs').'/'.$campus_id.'/'.$degree_id.'/'.$certificate_id)->body();
    }

    public function programs($program_id = null)
    {
        # code...
        // dd([ Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.programs'))->body(), Helpers::instance()->getApiRoot().'/'.config('api_routes.programs')]);
        return Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.programs').'/'.$program_id)->body();
    }


    public function campusPrograms($campus_id){
        // dd( [Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.campus_programs').'/'.$campus_id)->body(), Helpers::instance()->getApiRoot().'/'.config('api_routes.campus_programs').'/'.$campus_id]);
        return Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.campus_programs').'/'.$campus_id)->body();
    }


    public function campusProgramsBySchool($campus_id){
        // dd( [Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.campus_programs').'/'.$campus_id)->body(), Helpers::instance()->getApiRoot().'/'.config('api_routes.campus_programs').'/'.$campus_id]);
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

    public function max_matric($prefix, $year)
    {
        # code...
        return Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.max_matric').'/'.$prefix.'/'.$year)->body();
        // return Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.max_matric').'/'.$prefix)->body();
    }

    public function matric_exist($matric)
    {
        # code...
        return Http::post(Helpers::instance()->getApiRoot().'/'.config('api_routes.matric_exist'), ['matric'=>$matric])->body();
        // return Http::get(Helpers::instance()->getApiRoot().'/'.config('api_routes.max_matric').'/'.$prefix)->body();
    }

    public function degree_certificates($degree_id){
        // dd(Helpers::instance()->getApiRoot().'/degree/certificates/'.$degree_id);
        return Http::get(Helpers::instance()->getApiRoot().'/degree/certificates/'.$degree_id)->body();
    }
    
    public function set_degree_certificates($degree_id, array $certificate_ids){
        return Http::post(Helpers::instance()->getApiRoot().'/degree/certificates/'.$degree_id, ['certificates'=>$certificate_ids])->body();
    }

    public function portal_fee_structure($year_id = null){
        // dd(Helpers::instance()->getApiRoot().'/degree/certificates/'.$degree_id);
        return Http::get(Helpers::instance()->getApiRoot()."/portal_fee_structure/{$year_id}")->collect();
    }

    public function class_portal_fee_structure($program, $level, $year_id = null){
        // dd(Helpers::instance()->getApiRoot().'/degree/certificates/'.$degree_id);
        return Http::get(Helpers::instance()->getApiRoot()."/class_portal_fee_structure/{$program}/{$level}/{$year_id}")->collect();
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
}