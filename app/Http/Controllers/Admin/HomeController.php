<?php


namespace App\Http\Controllers\Admin;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\File;
use App\Models\PlatformCharge;
use App\Models\SchoolUnits;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Services\ApiService;

use function PHPUnit\Framework\returnSelf;

class HomeController  extends Controller
{
    var $api_service;
    public function __construct(ApiService $api_service)
    {
        # code...
        $this->api_service = $api_service;
    }

    public function index()
    {
        $raw =  $this->api_service->portal_fee_structure()['data']??[];
        $data = [];
        // dd($raw);
        if($raw != null){
            $data = collect($raw)->sortBy('class_name')->groupBy('school')->groupBy('department')->groupBy('program');
        }
        $_data['data'] = $data;
        return view('admin.dashboard', $_data);

    }

    public function set_letter_head()
    {
        # code...
        $data['title'] = __('text.upload_letter_head');
        return view('admin.setting.set-letter-head', $data);
    }

    public function save_letter_head(Request $request)
    {

        # code...
        $check = Validator::make($request->all(), ['file'=>'required|file|mimes:png,jpg,jpeg,gif,tif']);
        if ($check->fails()) {
            # code...
            return back()->with('error', $check->errors()->first());
        }
        
        $file = $request->file('file');
        // return $file->getClientOriginalName();
        if(!($file == null)){
            $ext = $file->getClientOriginalExtension();
            $filename = '_'.random_int(100000, 999999).'_'.time().'.'.$ext;
            $path = 'assets/images/avatars';
            if(!file_exists(url($path))){mkdir(url($path));}
            // $file->move(url($path), $filename);
            $file->move(public_path($path), $filename);
            if(File::where(['name'=>'letter-head'])->count() == 0){
                File::create(['name'=>'letter-head', 'path'=>$filename]);
            }else {
                File::where(['name'=>'letter-head'])->update(['path'=>$filename]);
            }
            return back()->with('success', __('text.word_done'));
        }
        return back()->with('error', __('text.error_reading_file'));
    }

    public function set_background_image()
    {
        # code...
        $data['title'] = __('text.set_background_image');
        return view('admin.setting.bg_image', $data);
    }

    public function save_background_image(Request $request)
    {
        # code...
        # code...
        $check = Validator::make($request->all(), ['file'=>'required|file|mimes:jpeg']);
        if ($check->fails()) {
            # code...
            return back()->with('error', $check->errors()->first());
        }
        $file = $request->file('file');
        // return $file->getClientOriginalName();
        if(!($file == null)){
            $ext = $file->getClientOriginalExtension();
            $filename = 'background_image.jpeg';
            // $path = $filename;
            if(!file_exists(url('/storage/app/bg_image'))){
                mkdir(url('/storage/app/bg_image'));
            }
            $file->move(url('/storage/app/bg_image'), $filename);
            return back()->with('success', __('text.word_done'));
        }
        return back()->with('error', __('text.error_reading_file'));
    }

    
    public function set_watermark()
    {
        # code...
        $data['title'] = __('text.set_watermark');
        return view('admin.setting.set_watermark', $data);
    }

    public function save_watermark(Request $request)
    {
        # code...
        # code...
        $check = Validator::make($request->all(), ['file'=>'required|file|mimes:jpeg']);
        if ($check->fails()) {
            # code...
            return back()->with('error', $check->errors()->first());
        }
        
        $file = $request->file('file');
        // return $file->getClientOriginalName();
        if(!($file == null)){
            $ext = $file->getClientOriginalExtension();
            $filename = 'logo.jpeg';
            $path = base_path('/assets/images');
            // $file->n('/bg_image', $filename);
            // \Storage::put($path, $file);
            $request->file('file')->move($path, $filename);
            return back()->with('success', __('text.word_done'));
        }
        return back()->with('error', __('text.error_reading_file'));
    }

    public function setayear()
    {
        $data['title'] = __('text.set_current_accademic_year');
        return view('admin.setting.setbatch')->with($data);
    }

    public function program_settings(Request $request)
    {
        # code...
        $data['title'] = __('text.program_settings');
        return view('admin.setting.program_settings', $data);
    }

    public function post_program_settings(Request $request)
    {
        # code...
        $program = SchoolUnits::find($request->program);
        // return $program;
        if ($program != null) {
            # code...
            $program->max_credit=$request->max_credit;
            $program->ca_total=$request->ca_total;
            $program->exam_total=$request->exam_total;
            $program->resit_cost=$request->resit_cost;
            $program->save();
            return back()->with('success', __('text.word_done'));
        }
        return back()->with('error', __('text.page_not_found'));
    }

    public function deletebatch($id)
    {
        if (DB::table('batches')->count() == 1) {
            return redirect()->back()->with('error', __('text.can_not_delete_last_batch'));
        }
        DB::table('batches')->where('id', '=', $id)->delete();
        return redirect()->back()->with('success', __('text.word_done'));
    }



    public function setAcademicYear($id)
    {
        // dd($id);
        $year = Config::all()->last();
        $data = [
            'year_id' => $id
        ];
        $year->update($data);

        return redirect()->back()->with('success', __('text.word_done'));
    }

    public function set_charges()
    {
        # code...
        $data['title'] = __('text.set_charges');
        return view('admin.setting.charges', $data);
    }

    public function save_charges(Request $request)
    {
        # code...
        // return $request->all();
        $validity = Validator::make($request->all(), [
            'year_id'=>'required',
            'yearly_amount'=>'numeric',
            'transcript_amount'=>'numeric',
            'result_amount'=>'numeric'
        ]);
        if($validity->failed()){
            return back()->with('error', $validity->errors()->first());
        }
        PlatformCharge::updateOrInsert(['year_id'=>$request->year_id], ['yearly_amount'=>$request->yearly_amount, 'result_amount'=>$request->result_amount, 'transcript_amount'=>$request->transcript_amount]);
        return back()->with('success', __('text.word_done'));
    }


    public function bypass_platform_charge()
    {
        # code...
        $data['title'] = "Bypass Platform Charges Payment";
        return view('admin.student.bypass_platform', $data);
    }
    
    public function bypass_platform_charge_save(Request $request)
    {
        # code...
        if($request->student_id == null){
            session()->flash('error', 'Student not specified');
            return back()->withInput();
        }
        $year = Helpers::instance()->getCurrentAccademicYear();

        $data = ['student_id'=>$request->student_id, 'year_id'=>$year, 'amount'=>0, 'financialTransactionId'=>'0', 'item_id'=>0, 'transaction_id'=>'0', 'used'=>1, 'type'=>'PLATFORM'];
        $instance = new \App\Models\Charge($data);
        $instance->save();
        return back()->with('success', 'Done');
    }

    public function _search_student(Request $request)
    {
        # code...
        $search_key = $request->key??'';
        
        return Students::where('name', 'LIKE', "%{$search_key}%")->orWhere('email', 'LIKE', "%{$search_key}%")->orWhere('phone', 'LIKE', "%{$search_key}%")->take(15)->get();
    }

    public function all_programs()
    {
        # code...
        $data['title'] = "All programs";
        $data['programs'] = collect(json_decode($this->api_service->programs())->data)->unique();
        return view('admin.programs.index', $data);
    }

    public function set_admins($prog_id = null)
    {
        # code...
        $data['title'] = "Set Administrators";
        $data['admins'] = \App\Models\ProgramAdmin::first();
        return view('admin.programs.set_admins', $data);
    }

    public function save_admins(Request $request, $prog_id = null)
    {
        //code...
        $validity = Validator::make($request->all(), [
            'chancellor'=>'required',
            'pro_chancellor'=>'required',
            'vice_chancellor'=>'required',
            'registrar'=>'required'
            ]
        );
        if ($validity->fails()) {
            # code...
            session()->flash('error', $validity->errors()->first());
            return back()->withInput();
        }

        $data = collect($request->all())->filter(function($value, $key){return $key != '_token';})->toArray();
        // dd($data);
        \App\Models\ProgramAdmin::first()->update($data);
        return back()->with('sucess', 'Done');
        
    }
}
