<?php

namespace App\Http\Controllers\Student;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Services\ApiService;
use App\Http\Services\AppService;
use App\Models\ApplicationForm;
use App\Models\Batch;
use App\Models\Config;
use App\Models\PlatformCharge;
use App\Models\Charge;
use App\Models\ProgramAdmin;
use App\Models\Transaction;
use App\Models\TranzakCredential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Exception\ConnectException;

class HomeController extends Controller
{
    private $years;
    private $batch_id;
    protected $appService;
    private $select = [
        'students.id as student_id',
        'collect_boarding_fees.id',
        'students.name',
        'students.matric',
        'collect_boarding_fees.amount_payable',
        'collect_boarding_fees.status',
        'school_units.name as class_name'
    ];

    private $select_boarding = [
        'students.id as student_id',
        'students.name',
        'students.matric',
        'collect_boarding_fees.id',
        'boarding_amounts.created_at',
        'boarding_amounts.amount_payable',
        'boarding_amounts.total_amount',
        'boarding_amounts.status',
        'boarding_amounts.balance'
    ];

    public function index()
    {
        if(auth('student')->user()->applicationForms()->whereNotNull('submitted')->where('year_id', Helpers::instance()->getCurrentAccademicYear())->count() > 0){
            return redirect(route('student.programs.index'));
        }
        return redirect(route('student.application.start', 0));
    }

    public function fee()
    {
        $data['title'] = "Tution Report";
        return view('student.fee')->with($data);
    }

    public function other_incomes()
    {
        $data['title'] = "Other Payments Report";
        return view('student.other_incomes', $data);
    }

    public function result(Request $request)
    {
        # code...
        $data['title'] = "My Result";
        return view('student.result')->with($data);
    }

    public function subject()
    {
        $data['title'] = "My Subjects";
        //     dd($data);
        return view('student.subject')->with($data);
    }

    public function profile()
    {
        return view('student.edit_profile');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|min:8',
            'phone' => 'required|min:9|max:15',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->with(['e' => $validator->errors()->first()]);
        }

        $data['success'] = 200;
        $user = auth('student')->user();
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();
        $data['user'] = auth('student')->user();
        return redirect()->back()->with(['s' => 'Phone Number and Email Updated Successfully']);
    }


    public function __construct( ApiService $service, AppService $appService)
    {
        // $this->middleware('isStudent');
        // $this->boarding_fee =  BoardingFee::first();
        //  $this->year = Batch::find(Helpers::instance()->getCurrentAccademicYear())->name;
        $this->batch_id = Batch::find(Helpers::instance()->getCurrentAccademicYear())->id;
        $this->years = Batch::all();
        $this->api_service = $service;
        $this->appService = $appService;
    }


    
    public function edit_profile()
    {
        # code...
        $data['title'] = "Edit Profile";
        return view('student.edit_profile', $data);
    }
    public function update_profile(Request $request)
    {
        # code...
        if(
            Students::where([
                'email' => $request->email, 'phone' => $request->phone
            ])->count() > 0 && (auth('student')->user()->phone != $request->phone || auth('student')->user()->email != $request->email)
        ){
            return back()->with('error', __('text.validation_phrase1'));
        }
        
        $data = $request->all();
        Students::find(auth('student')->id())->update($data);
        return redirect(route('student.home'))->with('success', __('text.word_Done'));
    }
 

    /* ______________________________________________________________________________________
    ONLINE APPLICATION SPECIFIC ACTIONS
    _______________________________________________________________________________________ */
    public function all_programs (Request $request)
    {
        # code...
        $data['title'] = "Our programs";
        $data['campuses'] = json_decode($this->api_service->campuses())->data??[];
        foreach ($data['campuses'] as $key => $value) {
            # code...
            $data['campuses'][$key]->programs = collect(json_decode($this->api_service->campusProgramsBySchool($value->id))->data)->unique()->groupBy('school');
        }
        // dd($data);
        return view('student.online.programs', $data);
    }

    public function start_application (Request $request, $step, $application_id = null)
    {
        try {

            if(auth('student')->user()->applicationForms()->whereNotNull('submitted')->where('year_id', Helpers::instance()->getCurrentAccademicYear())->count() > 0){
                return redirect()->route('student.home')->with('error', "You are allowed to submit only one application form per year");
            }

            // check if application is open now
            if(!(Helpers::instance()->application_open())){
                return redirect(route('student.home'))->with('error', 'Application closed for '.Batch::find(Config::all()->last()->year_id)->name);
            }
            
            
            # code...
            // return $this->api_service->campuses();
            $data['campuses'] = json_decode($this->api_service->campuses())->data;
            $application = ApplicationForm::where(['student_id'=>auth('student')->id(), 'year_id'=>Helpers::instance()->getCurrentAccademicYear()])->first();
            if($application == null){
                $application = new ApplicationForm();
                $application->student_id = auth('student')->id();
                $application->year_id = Helpers::instance()->getCurrentAccademicYear();
                $application->save();
            }

            if ($request->_prg != null) {
                # code...
                if($request->_prg == 173){
                    return redirect("https://bsph.cbchealthservices.org/admissions/#ad-requirements");
                }
                $application->program_first_choice = $request->_prg;
                $application->save();
            }

            $data['application'] = $application;
            if($application->campus_id != null){
                $data['programs'] = collect(json_decode($this->api_service->campusPrograms($application->campus_id))->data)->where('degree_id', $application->degree_id);
            }
    
            if($data['application']->degree_id != null){
                $data['degree'] = collect(json_decode($this->api_service->degrees())->data)->where('id', $data['application']->degree_id)->first();
            }
            if($data['application']->campus_id != null){
                $data['campus'] = collect($data['campuses'])->where('id', $data['application']->campus_id)->first();
            }
            if($data['application']->degree_id != null){
                // dd(json_decode($this->api_service->degree_certificates($data['application']->degree_id)));
                $certs = json_decode($this->api_service->degree_certificates($data['application']->degree_id))->data;
                if(is_array($certs) && count($certs)>0){ $data['certs'] = $certs;
                }else{ $data['certs'] = json_decode($this->api_service->certificates())->data; }
            }
            if($data['application']->entry_qualification != null){
                // dd($this->api_service->campusDegreeCertificatePrograms($data['application']->campus_id, $data['application']->degree_id, $data['application']->entry_qualification));
                $data['programs'] = json_decode($this->api_service->campusDegreeCertificatePrograms($data['application']->campus_id, $data['application']->degree_id, $data['application']->entry_qualification))->data;
                $data['cert'] = collect($data['certs'])->where('id', $data['application']->entry_qualification)->first();
                // dd($data['programs']);
            }
            if($data['application']->program_first_choice != null and isset($data['programs'])){
                $data['program1'] = collect($data['programs'])->where('id', $data['application']->program_first_choice)->first();
                $data['program2'] = collect($data['programs'])->where('id', $data['application']->program_second_choice)->first();
                $data['program3'] = collect($data['programs'])->where('id', $data['application']->program_third_choice)->first();
                // return $data;
            }

            // Assuming we are using direct momo payment
            // dd($step);
            $transaction = $application->transaction;
            $tranzak_transaction = $application->tranzak_transaction;
            $data['step'] = $step;
            if($step == 6.5 and $application->is_filled()){$data['step'] = $step;}
            elseif($tranzak_transaction == null and $application->payment_method == 'MOMO'){
                if(($application->degree_id == null) and ($step != 0)){$data['step'] = 0;}
                // elseif(($transaction == null and $application->degree_id != null) and !in_array($step, [0, 6, 6.5])){$data['step'] = $step == 6 ? 6 : 6.5;}
                // elseif(($application->degree_id != null) and ($transaction != null) and ($transaction->payment_id != $application->degree_id) and $step == 1 ){$data['step'] = $step == 6 ? 6 : 6.5;}
                elseif(($application->degree_id != null) and ($transaction != null) and ($transaction->payment_id != $application->degree_id) and !in_array($step, [0, 6])){$data['step'] = 0;}
            }elseif($application->payment_method == null and $application->degree_id != null  and $data['step'] > 0){
                $data['step'] = 6;
            }
            
            
            // $isMaster = in_array('degree', $data) and stristr($data['degree']->deg_name??"", "master");
            // $data['isMaster'] = $isMaster;
            // if ($step == 3) {
            //     if(!$isMaster){
            //         $data['step'] = 4;
            //     }
            // }
            
            $data['title'] = (isset($data['degree']) and ($data['degree'] != null)) ? $data['degree']->deg_name." APPLICATION" : "APPLICATION";

            // dd($data['step']);
            return view('student.online.fill_form', $data);
        } catch (\Throwable $th) {
            throw $th;
            return back()->with('error', $th->getMessage());
        }
    }

    public function persist_application(Request $request, $step, $application_id)
    {
        # code...
        // return $request->all();
        
        // check if application is open now
        if(!(Helpers::instance()->application_open())){
            return redirect(route('student.home'))->with('error', 'Application closed for '.Batch::find(Config::all()->last()->year_id)->name);
        }
        switch ($step) {
            case 1:
                # code...
                
                $validity = Validator::make($request->all(), [
                    'campus_id'=>'required', 'degree_id'=>'required'
                ]);
                break;
            
            case 2:
                # code...
                $validity = Validator::make($request->all(), [
                    "first_name"=>'required', "other_names"=>'required', "gender"=> "required",
                    "dob"=> "required", "pob"=> "required", "nationality"=> "required", 
                    "residence"=> "required", "phone"=> "required", 'email'=>'required|email', 
                    'division'=>'required', 'region'=>'required', 'marital_status'=>'required', 
                    'id_number'=>'required', 'id_place_of_issue'=>'required', 'id_date_of_issue'=>'required', 
                    'id_expiry_date'=>'required', 'disability'=>'nullable', 'health_condition'=>'nullable', 
                    'emergency_address'=>'required', 'emergency_tel'=>'required', 'emergency_name'=>'required', 
                    'emergency_email'=>'email', 'emergency_personality'=>'required'
                ]);
                break;
                
            case 3:
                # code...
                
                $validity = Validator::make($request->all(), [
                    'program_first_choice'=>'required', 'program_second_choice'=>'required',
                    'level'=>'required', 
                ]);
                break;
            

            case 4:
                $validity = Validator::make($request->all(), [
                    'schools_attended'=>'required|array', 
                ]);
                break;

            case 5:
                $validity = Validator::make($request->all(), []);
                break;
                
            case 6: case 6.5:
                // dd($request->all());
                $validity = Validator::make($request->all(), [
                    
                ]);
                # code...
                break;
            
            case 7:
                # code...
                // return $request->all();
                // momo-number validated with country code for cameroon: 237
                $validity = Validator::make($request->all(), [
                    "momo_number"=> "size:9", "amount"=> "numeric|min:1", 'payment_method'=>'nullable'
                ]);
                break;
            
        }

        if($step == 8){
            ApplicationForm::where('id', $application_id)->update(['submitted'=>now()]);
            // // SEND SMS
            $phone_number = auth('student')->user()->phone;
            if(str_starts_with($phone_number, '+')){
                $phone_number = substr($phone_number, '1');
            }
            if(strlen($phone_number) <= 9){
                $phone_number = '237'.$phone_number;
            }
            // dd($phone_number);
            $message="Application into Baptist School of Public Health submitted successfully.";
            $sent = $this->sendSMS($phone_number, $message);
            return redirect(route('student.application.form.download', ['id'=>$application_id]));
        }

        
        // dd($request->all());
        if($validity->fails()){
            session()->flash('error', $validity->errors()->first());
            return back()->withInput();
        }
        
        // dd($step);
        // persist data
        $data = [];
        $appl = ApplicationForm::find($application_id);
        $transaction = $appl->transaction;
        $tranzak_transaction = $appl->tranzak_transaction;
        // if($tranzak_transaction == null){
        //     if(($appl->degree_id == null) and ($step != 1)){$step = 1;}
        //     elseif(($transaction == null and $appl->degree_id != null) and !in_array($step, [1, 7])){$step = 7;}
        //     elseif(($appl->degree_id != null) and ($transaction != null) and ($transaction->payment_id != $appl->degree_id) and !in_array($step, [1,7])){$step = 7;}
        // }

        if($step == 4){
            $data_p1=[];
            $_data = $request->schools_attended;
            // dd($_data);
            if($_data != null){
                foreach ($_data as $key => $value) {
                    $data_p1[] = ['school'=>$value['school'], 'date_from'=>$value['date_from'], 'date_to'=>$value['date_to'], 'qualification'=>$value['qualification']];
                }
                $data['schools_attended'] = json_encode($data_p1);
                // dd($data);
            }
            
            $data = collect($data)->filter(function($value, $key){return !in_array($key, ['_token', 'first_name', 'other_names']) and $value != null;})->toArray();
            $application = ApplicationForm::updateOrInsert(['id'=> $application_id, 'student_id'=>auth('student')->id()], $data);
        }elseif($step == 5){
            $data = $request->all();
            // dd($request->al_results);
            if($request->ol_results != null){
                $ol_results = [];
                foreach($request->ol_results as $rec){
                    $ol_results[] = ['subject'=>$rec['subject'], 'grade'=>$rec['grade']];
                }
                $data['ol_results'] = json_encode($ol_results);
            }
            if($request->al_results != null){
                $al_results = [];
                foreach($request->al_results as $rec){
                    $al_results[] = ['subject'=>$rec['subject'], 'grade'=>$rec['grade']];
                }
                $data['al_results'] = json_encode($al_results);
            }
            $data = collect($data)->filter(function($value, $key){return $key != '_token';})->toArray();
            ApplicationForm::updateOrInsert(['id'=> $application_id, 'student_id'=>auth('student')->id()], $data);

        }elseif($step == 7){
            
            // dd('check point');
            if($request->payment_method != null){
                $appl->update(['payment_method'=>$request->payment_method]);
                return redirect(route('student.application.start', ['id'=>$application_id, 'step'=>1]));
            }elseif($request->payment_proof != null){
                if(($file = $request->file('payment_proof')) != null){
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'payment_proof'.$appl->id.'_'.time().'.'.$extension;
                    $file->storeAs('payment_proof', $filename, ['disk'=>'public_uploads']);
                    ApplicationForm::where(['id'=> $application_id, 'student_id' => auth('student')->id()])->update(['submitted'=>now(), 'payment_proof'=>asset('uploads/payment_proof/'.$filename)]);
                    return redirect(route('student.application.form.download'))->with('success', "You have completed your application process");
                }
            }else{
                $batch = \App\Models\Batch::find(Helpers::instance()->getCurrentAccademicYear());
                
                $pay_channel = $batch->pay_channel;
                if($pay_channel == null){
                    session()->flash('error', "System payment channel not set");
                    return back();
                }
                $application = auth('student')->user()->applicationForms()->where('year_id', Helpers::instance()->getCurrentAccademicYear())->first();
                switch($pay_channel){
                    case 'momo':
    
                        // MAKE CALLS TO DIRECT MOMO API, REQUEST TO PAY
                        $req_data = [
                            'student_id'=>$application->student_id, 
                            'year_id'=>$application->year_id, 
                            'amount'=>$request->amount, 
                            'payment_id'=>$application->degree_id, 
                            'payment_purpose'=>'APPLICATION FEE', 
                            'tel'=> (strlen($request->momo_number) ==  9 ? '237'.$request->momo_number : $request->momo_number)
                        ];
                        $response = Http::post(env('PAYMENT_URL'), $req_data);
                        $resp_data = $response->collect();
                        // dd($resp_data);
                        if($resp_data->count() > 0 and $resp_data->first() != null){
                            return redirect(route('student.momo.processing', $resp_data->first()));
                        }else{
                            // return $response->body();
                            return back()->with('error', $response->body());
                        }
                        break;
    
                    case 'tranzak':
                        // MAKE API CALL TO PERFORM PAYMENT OF APPLICATION FEE
                        // check if token exist and hasn't expired or get new token otherwise
            
                        $token_refreshed = 0;
                        $tranzak_credentials = TranzakCredential::where('campus_id', $application->campus_id)->first();
                        if(cache($tranzak_credentials->cache_token_key) == null or Carbon::parse(cache($tranzak_credentials->cache_token_expiry_key))->isAfter(now())){
            
                            GEN_TOKEN:
                            $response = Http::post(config('tranzak.base').config('tranzak.token'), ['appId'=>$tranzak_credentials->app_id, 'appKey'=>$tranzak_credentials->api_key]);
                            $token_refreshed++;
                            if($response->status() == 200){
                                cache([$tranzak_credentials->cache_token_key => json_decode($response->body())->data->token]);
                                cache([$tranzak_credentials->cache_token_expiry_key=>Carbon::createFromTimestamp(time() + json_decode($response->body())->data->expiresIn)]);
                            }
            
                        }
                        // dd('check point X1');
                        
                        $headers = ['Authorization'=>'Bearer '.cache($tranzak_credentials->cache_token_key)];
                        $request_data = ['mobileWalletNumber'=>'237'.$request->momo_number, 'mchTransactionRef'=>'_apl_fee_'.time().'_'.random_int(1, 9999), "amount"=> $request->amount, "currencyCode"=> "XAF", "description"=>"Payment for application fee into BSPH UNIVERSITY INSTITUTE OF BUEA", 'returnUrl'=>route('tranzak.returnUrl')];
                        $_response = Http::withHeaders($headers)->post(config('tranzak.base').config('tranzak.direct_payment_request'), $request_data);
                        // dd($_response->collect());
                        if($_response->status() == 200){
            
                            session()->put('processing_tranzak_transaction_details', json_encode(json_decode($_response->body())->data));
                            session()->put('tranzak_credentials', json_encode($tranzak_credentials));
                            return redirect()->to(route('student.application.payment.processing', $application_id));
                        }elseif($token_refreshed < 2){
                            // considering the existing token is no longer valid
                            goto GEN_TOKEN;
                        }
            
                        session()->flash('error', 'Payment Failed. Make sure you have an internet connection and try again later.');
                        return back()->withInput();
                        break;
                }
            }


            // dd('check point X2');
        }else{
            // dd('check point X3');
            $data = $request->all();
            if(array_key_exists('first_name', $data)){
                $data['name'] = $data['first_name']."   ".$data['other_names'];
            }
            $data = collect($data)->filter(function($value, $key){return !in_array($key, ['_token', 'first_name', 'other_names']) and $value != null;})->toArray();
            $application = ApplicationForm::updateOrInsert(['id'=> $application_id, 'student_id'=>auth('student')->id()], $data);
            // dd('check point X4');

        }
        
        // $step = (ApplicationForm::where('id', $application_id)->whereNotNull('transaction_id')->count() == 0 ) ? 6 : $request->step;
        GOPAY:
        return redirect(route('student.application.start', [$step, $application_id]));
    }

    public function pending_payment(Request $request, $application_id)
    {
        # code...
        
        // check if application is open now
        if(!(Helpers::instance()->application_open())){
            return redirect(route('student.home'))->with('error', 'Application closed for '.Helpers::instance()->getYear()->name);
        }
        $data['title'] = "Processing Transaction";
        $data['form_id'] = $application_id;
        $data['tranzak_credentials'] = json_decode(session()->get('tranzak_credentials'));
        $data['transaction'] = json_decode(session()->get('processing_tranzak_transaction_details'));
        // return $data;
        return view('student.online.processing_payment', $data);
        
    }

    public function pending_complete(Request $request, $appl_id)
    {
        # code...
        try {
            
            // check if application is open now
            // if(!(Helpers::instance()->application_open())){
            //     return redirect(route('student.home'))->with('error', 'Application closed for '.Helpers::instance()->getYear()->name);
            // }
            //code...
            $transaction_status = (object) $request->all();
            // return $transaction_status;
            switch ($transaction_status->status) {
                case 'SUCCESSFUL':
                    # code...
                    // save transaction and update application_form
                    $transaction = ['request_id'=>$transaction_status->requestId, 'amount'=>$transaction_status->amount, 'currency_code'=>$transaction_status->currencyCode, 'purpose'=>"application fee", 'mobile_wallet_number'=>$transaction_status->mobileWalletNumber, 'transaction_ref'=>$transaction_status->mchTransactionRef, 'app_id'=>$transaction_status->appId, 'transaction_time'=>$transaction_status->transactionTime, 'payment_method'=>((object)($transaction_status->payer))->paymentMethod, 'payer_user_id'=>((object)($transaction_status->payer))->userId, 'payer_name'=>((object)($transaction_status->payer))->name, 'payer_account_id'=>((object)($transaction_status->payer))->accountId, 'merchant_fee'=>((object)($transaction_status->merchant))->fee, 'merchant_account_id'=>((object)($transaction_status->merchant))->accountId, 'net_amount_recieved'=>((object)($transaction_status->merchant))->netAmountReceived];
                    $transaction_instance =  \App\Models\TranzakTransaction::updateOrInsert(['transaction_id'=>$transaction_status->transactionId], $transaction);
                    $transaction_instance = \App\Models\TranzakTransaction::where(['transaction_id'=>$transaction_status->transactionId])->first();
    
                    $appl = ApplicationForm::find($appl_id);
                    $appl->transaction_id = $transaction_instance->id;
                    $appl->save();
                    $this->persist_application(new Request(), 8, $appl->id);
                    return redirect(route('student.application.form.download'))->with('success', "Payment successful. Application submitted successfully");
                    break;
                
                case 'CANCELLED':
                    # code...
                    // notify user
                    return redirect(route('student.home'))->with('message', 'Payment Not Made. The request was cancelled.');
                    break;
                
                case 'FAILED':
                    # code...
                    return redirect(route('student.home'))->with('error', 'Payment failed.');
                    break;
                
                case 'REVERSED':
                    # code...
                    return redirect(route('student.home'))->with('message', 'Payment failed. The request was reversed.');
                    break;
                
                default:
                    # code...
                    break;
            }
            return redirect(route('student.home'))->with('error', 'Payment failed. Unrecognised transaction status.');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', $th->getMessage());
        }
    }

    public function submit_application(Request $request){
        
        // check if application is open now
        if(!(Helpers::instance()->application_open())){
            return redirect(route('student.home'))->with('error', 'Application closed for '.\App\Models\Batch::find(Helpers::instance()->getYear())->name);
        }
        $applications = auth('student')->user()->currentApplicationForms()->whereNull('transaction_id')->get();
        $data['title'] = "Submit Application";
        $data['applications'] = $applications;
        return view('student.online.submit_form', $data);
    }

    public function submit_application_save(Request $request, $appl_id)
    {
        # code...
        $application = ApplicationForm::find($appl_id);
        if($application != null){
            $application->submitted = now();
            $application->save();
            return back()->with('success', 'Application submitted.');
        }
        return back()->with('error', 'Application could not be found.');
    }

    public function download_application_form()
    {
        # code...
        $data['title'] = "Download Application Form";
        $data['_this'] = $this;
        // $data['applications'] = auth('student')->user()->applicationForms->whereNotNull('transaction_id');
        $data['applications'] = auth('student')->user()->applicationForms()->whereNotNull('submitted')->get();
        return view('student.online.download_form', $data);
    }

    public function download_form(Request $request, $application_id)
    {
        // dd($application_id);
        # code...
        try{
            return $this->appService->application_form($application_id);
        }catch(Throwable $th){
            return back()->with('error', "\nFile : {$th->getFile()}\nMessage : {$th->getMessage()} \nLine : {$th->getLine()}");
        }
    }

    public function payment_data ()
    {
        # code...
        $data['title'] = "Payment Data";
        $data['payments'] = ApplicationForm::where('student_id', auth('student')->id())->whereNotNull('submitted')->get();
        if(request('appl') != null){
            $data['appl'] = ApplicationForm::find(request('appl'));
        }
        foreach ($data['payments'] as $key => $value) {
            # code...
            $data['payments'][$key]->campus = collect(json_decode($this->api_service->campuses())->data)->where('id', $value->campus_id)->first();
            $data['payments'][$key]->degree = collect(json_decode($this->api_service->degrees())->data)->where('id', $value->degree_id)->first();
        }
        return view('student.online.payment_data', $data);
    }

    public function download_admission_letter()
    {
        # code...
        $data['title'] = "Download Admission Letter";
        $data['_this'] = $this;
        $data['applications'] = auth('student')->user()->applicationForms->where('admitted', 1);
        // return $data;
        return view('student.online.admission_letter', $data);
    }

    public function download_admission_letter_save(Request $request, $appl_id)
    {
        return $this->appService->admission_letter($appl_id);
    }

    //---------
    public function pay_platform_charges(Request $request)
    {
        # code...
        $student = auth('student')->user();
        $charge = PlatformCharge::where('year_id', Helpers::instance()->getCurrentAccademicYear())->first();
        if($charge == null || $charge->yearly_amount == null || $charge->yearly_amount == 0){return back()->with('error', 'Platform charges not set.');}
        if($student->hasPaidPlatformCharges($request->year_id)){return redirect(route('student.home'))->with('message', 'Platform charges already paid for this year.');}
        $data['title'] = "Pay Platform Charges";
        $data['amount'] = $charge->yearly_amount;
        $data['purpose'] = 'PLATFORM';
        $data['year_id'] = $request->year_id ?? null;
        $data['payment_id'] = $charge->id;
        return view('student.platform.charges', $data);
    }

    //---------
    public function pay_charges_save(Request $request)
    {
        # code...
        // dd(153543);
        $validator = Validator::make($request->all(),
        [
            'tel'=>'required|numeric|min:9',
            'amount'=>'required|numeric',
            // 'callback_url'=>'required|url',
            'student_id'=>'required|numeric',
            'year_id'=>'required|numeric',
            'payment_purpose'=>'required',
            'payment_id'=>'required|numeric'
        ]);
        try {
            //code...
            if ($validator->fails()) {
                # code...
                return back()->with('error', $validator->errors()->first());
            }
            // return $request->all();
    
            // // BRIDGE PROCESS BY PAYING WITH TRANZAK
            // {
            //     $data = $request->all();
            //     $data_key = $request->payment_purpose == '_TRANSCRIPT_' ? config('tranzak.tranzak._transcript_data') : config('tranzak.tranzak.platform_data');
            //     session()->put($data_key, $data);
            //     // dd($data);
            //     return $this->tranzak_pay($request->payment_purpose, $request);
            // }
    
            try {
                //code...
                $data = $request->all();
                $response = Http::post(env('CHARGES_PAYMENT_URL', "http://localhost/NISHANG/boap_raw_pay/api/make-payments"), $data);
                // dd($response->body());
                if(!$response->ok()){
                    // throw $response;
                    return back()->with('error', 'Operation failed. '.$response->body());
                    // dd($response->body());
                }
                
                if($response->ok()){
                
                    $_data['title'] = "Pending Confirmation";
                    $_data['transaction_id'] = $response->collect()->first();
                    // return $_data;
                    return view('student.platform.payment_waiter', $_data);
                }
            } 
            catch(ConnectException $e){
                // throw $e;
                return back()->with('error', $e->getMessage());
            }
        } catch (\Throwable $th) {
            throw $th;
            session()->flash('error', "F::{$th->getFile()}, L::{$th->getLine()}, M::{$th->getMessage()}");
            return back();
        }
        
    }

    //----------
    public function complete_charges_transaction(Request $request, $ts_id)
    {
        # code...

        $transaction = Transaction::where(['transaction_id'=>$ts_id])->first();
        if($transaction != null){
            // update transaction
            $transaction->status = "SUCCESSFUL";
            $transaction->is_charges = true;
            $transaction->financialTransactionId = $request->financialTransactionId;
            $transaction->save();
            // return $transaction;
            // update payment record
            // CHECK PAYMENT PURPOSE, EITHER 
            switch($transaction->payment_purpose){
                case 'PLATFORM':
                case 'RESULTS':
                    $charge = new Charge();
                    $data = [
                        "student_id"=>$transaction->student_id,
                        "year_id"=>$transaction->year_id,
                        'semester_id'=>$transaction->semester_id??0,
                        'type'=>$transaction->payment_purpose,
                        "item_id"=>$transaction->payment_id,
                        "amount"=>$transaction->amount,
                        "financialTransactionId"=>$request->financialTransactionId,
                    ];
                    $charge->fill($data);
                    $charge->save();
                    return redirect(route('student.application.start', 0))->with('success', 'Payment complete');
                    break;

                case 'TRANSCRIPT':
                    // set used to 0 on transactions to indicate that the transcript associated to the transaction is not yet done.


                    $charge = new Charge();
                    $data = [
                        "student_id"=>$transaction->student_id,
                        "year_id"=>$transaction->year_id,
                        'semester_id'=>$transaction->semester_id ?? null,
                        'type'=>$transaction->payment_purpose,
                        "item_id"=>$transaction->payment_id,
                        "amount"=>$transaction->amount,
                        "financialTransactionId"=>$request->financialTransactionId,
                        'used'=>false
                    ];
                    $charge->fill($data);
                    $charge->save();
                    $_data['title'] = "Apply For Transcript";
                    $_data['charge_id'] = $charge->id;
                    return view('student.transcript.apply', $_data)->with('success', 'Payment complete');
                    break;

            }
        }
    }

    //-----------
    public function failed_charges_transaction(Request $request, $ts_id)
    {
        # code...
        $transaction = Transaction::where(['transaction_id'=>$ts_id])->first();
        if($transaction != null){
            // update transaction
            $transaction->status = "FAILED";
            $transaction->financialTransactionId = $request->financialTransactionId;
            $transaction->is_charges = 'true';
            $transaction->save();
            switch($transaction->payment_purpose){
                case 'TRANSCRIPT':
                case 'RESULTS':
                case 'PLATFORM':
                    // DB::table('transcripts')->where(['student_id'=>auth('student')->id(), 'paid'=>0])->delete();
                    return redirect(route('student.home'))->with('error', 'Operation Failed');
                    break;
            }

            // redirect user
            return redirect(route('student.home'))->with('error', 'Operation failed.');
        }
    }


    //--------------    
    public function tranzak_pay(string $purpose, Request $request){

        $validator = Validator::make($request->all(),
        [
            'tel'=>'required|numeric|min:9',
            'amount'=>'required|numeric',
            // 'callback_url'=>'required|url',
            'student_id'=>'required|numeric',
            'year_id'=>'required|numeric',
            'payment_purpose'=>'required',
            'payment_id'=>'required|numeric'
        ]);
        
        
        // MAKE API CALL TO PERFORM PAYMENT OF APPLICATION FEE
        // check if token exist and hasn't expired or get new token otherwise
        $application = auth('student')->user()->applicationForms()->where('year_id', Helpers::instance()->getCurrentAccademicYear())->first();
        $tranzak_credentials = \App\Models\TranzakCredential::where('campus_id', 0)->first();
        if(cache($tranzak_credentials->cache_token_key) == null or Carbon::parse(cache($tranzak_credentials->cache_token_expiry_key))->isAfter(now())){
            GEN_TOKEN:
            $response = Http::post(config('tranzak.tranzak.base').config('tranzak.tranzak.token'), ['appId'=>$tranzak_credentials->app_id, 'appKey'=>$tranzak_credentials->api_key]);
            if($response->status() == 200){
                cache([$tranzak_credentials->cache_token_key => json_decode($response->body())->data->token]);
                cache([$tranzak_credentials->cache_token_expiry_key=>Carbon::createFromTimestamp(time() + json_decode($response->body())->data->expiresIn)]);
            }
        }

        $tel = strlen($request->tel) >= 12 ? $request->tel : '237'.$request->tel;
        $headers = ['Authorization'=>'Bearer '.cache($tranzak_credentials->cache_token_key)];
        $request_data = ['mobileWalletNumber'=>$tel, 'mchTransactionRef'=>'_'.str_replace(' ', '_', $request->payment_purpose).'_payment_'.time().'_'.random_int(1, 9999), "amount"=> $request->amount, "currencyCode"=> "XAF", "description"=>"Payment for {$request->payment_purpose} - BSPH UNIVERSITY INSTITUTE OF BUEA.", 'returnUrl'=>route('tranzak.returnUrl')];
        $_response = Http::withHeaders($headers)->post(config('tranzak.tranzak.base').config('tranzak.tranzak.direct_payment_request'), $request_data);
        // dd($_response->collect());
        if($_response->collect()['success'] == true){

            // create pending transaction
            $resp_data = $_response->collect()['data'];
            $pending_tranzaktion = [
                "request_id"=>$resp_data['requestId'],"amount"=>$resp_data['amount'],"currency_code"=>$resp_data['currencyCode'],"description"=>$resp_data['description'],"transaction_ref"=>$resp_data['mchTransactionRef'],"app_id"=>$resp_data['appId'], 'transaction_time'=>$resp_data['createdAt'],'user_type'=>'student', 'purpose'=>$request->payment_purpose,
                "payment_id"=>$request->payment_id,"student_id"=>auth('student')->id(),"batch_id"=>$request->year_id,'unit_id'=>0,"original_amount"=>$request->amount,"reference_number"=>'platform.tranzak_momo_payment_'.time().'_'.random_int(100000, 999999).'_'.auth('student')->id(), 'paid_by'=>'TRANZAK_MOMO', 'mobile_wallet_number'=>$resp_data['mobileWalletNumber']
            ];
            $pt_instance = new \App\Models\PendingTranzakTransaction($pending_tranzaktion);
            $pt_instance->save();

            session()->put('processing_tranzak_transaction_details', json_encode($_response->collect()['data']));
            session()->put('tranzak_credentials', json_encode($tranzak_credentials));
            return redirect()->to(route('student.tranzak.processing', $request->payment_purpose));
        }else {
            goto GEN_TOKEN;
        }
        return back()->with('error', 'Unknown error occured');

    }

    //-----------------
    public function tranzak_payment_processing()
    {
        # code...
        $data['title'] = "Processing Payment Request";
        $data['tranzak_credentials'] = TranzakCredential::where('campus_id', 0)->first();
        $data['transaction'] = json_decode(session('processing_tranzak_transaction_details'));
        // dd(1573);
        return view('student.momo.processing', $data);
    }

    //----------------
    public function tranzak_complete(Request $request)
    {
        # code...
        try {
            //code...
            // return $request;
            // dd(session()->get('processing_tranzak_transaction_details'));
            // dd($request->all());
            switch ($request->status) {
                case 'SUCCESSFUL':
                    # code...
                    // save transaction and update application_form
                    DB::beginTransaction();
                    $transaction = [
                        'request_id'=>$request->requestId??'', 'amount'=>$request->amount??'', 
                        'currency_code'=>$request->currencyCode??'', 'purpose'=>$request->payment_purpose??'', 
                        'mobile_wallet_number'=>$request->mobileWalletNumber??'', 
                        'transaction_ref'=>$request->mchTransactionRef??'', 'app_id'=>$request->appId??'', 
                        'transaction_id'=>$request->transactionId??'', 'transaction_time'=>$request->transactionTime??'', 
                        'payment_method'=>$request->payer['paymentMethod']??'', 'payer_user_id'=>$request->payer['userId']??'', 
                        'payer_name'=>$request->payer['name']??'', 'payer_account_id'=>$request->payer['accountId']??'', 
                        'merchant_fee'=>$request->merchant['fee']??'', 'merchant_account_id'=>$request->merchant['accountId']??'', 
                        'net_amount_recieved'=>$request->merchant['netAmountReceived']??''
                    ];
                    if(\App\Models\TranzakTransaction::where($transaction)->count() == 0){
                        $transaction_instance = new \App\Models\TranzakTransaction($transaction);
                        $transaction_instance->save();
                    }else{
                        $transaction_instance = \App\Models\TranzakTransaction::where($transaction)->first();
                    }
    
                    $trans = json_decode(session()->get('processing_tranzak_transaction_details'));
                    $payment_data = session()->get(config('tranzak.tranzak.platform_data'));
                    // dd($payment_data);
                    // dd($transaction_instance);
                    $data = ['student_id'=>$payment_data['student_id'], 'year_id'=>$payment_data['year_id'], 'type'=>'PLATFORM', 'item_id'=>$payment_data['payment_id'], 'amount'=>$transaction_instance->amount, 'financialTransactionId'=>$transaction_instance->transaction_id, 'used'=>1];
                    $instance = new \App\Models\Charge($data);
                    $instance->save();
                    $message = "Hello ".(auth('student')->user()->name??'').", You have successfully paid a sum of ".($transaction_instance->amount??'')." as ".($trans->payment_purpose??'')." for ".($transaction_instance->year->name??'')." HIMS UNIVERSITY INSTITUTE.";
                    $this->sendSmsNotificaition($message, [auth('student')->user()->phone]);
                    
                    ($pending = \App\Models\PendingTranzakTransaction::where('request_id', $request->requestId)->first()) != null ? $pending->delete() : null;
                    DB::commit();
                    return redirect(route('student.home'))->with('success', "Payment successful.");
                    break;
                
                case 'CANCELLED':
                    # code...
                    // notify user
                    ($pending = \App\Models\PendingTranzakTransaction::where('request_id', $request->requestId)->first()) != null ? $pending->delete() : null;
                    return redirect(route('student.home'))->with('message', 'Payment Not Made. The request was cancelled.');
                    break;
                
                case 'FAILED':
                    # code...
                    ($pending = \App\Models\PendingTranzakTransaction::where('request_id', $request->requestId)->first()) != null ? $pending->delete() : null;
                    return redirect(route('student.home'))->with('error', 'Payment failed.');
                    break;
                
                case 'REVERSED':
                    # code...
                    ($pending = \App\Models\PendingTranzakTransaction::where('request_id', $request->requestId)->first()) != null ? $pending->delete() : null;
                    return redirect(route('student.home'))->with('message', 'Payment failed. The request was reversed.');
                    break;
                
                default:
                    # code...
                    break;
            }

            return redirect(route('student.home'))->with('error', 'Payment failed. Unrecognised transaction status.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            session()->flash('error', "F::{$th->getFile()}, L::{$th->getLine()}, M::{$th->getMessage()}");
            return back();
        }
    }

    public function raw_momo_processing($transaction_id){
        $data['title'] = "Processing Direct Momo Transaction";
        $data['transaction_id'] = $transaction_id;
        // return view('student.momo.processing', $data);
        return view('student.raw_payment_waiter', $data);
    }

    
    public function complete_transaction(Request $request, $ts_id)
    {
        # code...

        $transaction = Transaction::where(['transaction_id'=>$ts_id])->first();
        // dd($transaction);
        if($transaction != null){
            // update transaction
            $transaction->status = "SUCCESSFUL";
            $transaction->financialTransactionId = $request->financialTransactionId;
            $transaction->save();

            $form = ApplicationForm::where(['year_id'=>$transaction->year_id, 'student_id'=>$transaction->student_id])->first();
            if($form == null){
                return redirect(route('student.home'))->with('error', "Application form could not be found");
            }
            $form->update(['transaction_id'=>$transaction->id]);
            return redirect()->to(route('student.application.start', ['id'=>$form->id, 'step'=>1]))->with('success', "Payment complete");
        }
    }

    public function failed_transaction(Request $request, $ts_id)
    {
        # code...
        $transaction = Transaction::where(['transaction_id'=>$ts_id])->first();
        if($transaction != null){
            // update transaction
            $transaction->delete();
        }
        return redirect()->to(route('student.home'))->with('error', 'Operation failed.');
    }

    
    public function _complete_transaction(Request $request, $ts_id)
    {
        # code...

        // dd($request->all());
        $transaction = Transaction::where(['transaction_id'=>$ts_id])->first();
        if($transaction != null){
            // update transaction
            $transaction->status = "SUCCESSFUL";
            $transaction->financialTransactionId = $request->financialTransactionId;
            $transaction->save();
            
            $form = ApplicationForm::where(['year_id'=>$transaction->year_id, 'student_id'=>$transaction->student_id])->first();
            if($form == null){
                return redirect(route('student.home'))->with('error', "Application form could not be found");
            }
            // dd($transaction);
            $form->update(['transaction_id'=>$transaction->id]);
            return redirect()->to(route('student.application.start', ['id'=>$form->id, 'step'=>1]))->with('success', "Payment complete");
        }
    }

    public function _failed_transaction(Request $request, $ts_id)
    {
        # code...
        $transaction = Transaction::where(['transaction_id'=>$ts_id])->first();
        if($transaction != null){
            // update transaction
            $transaction->delete();
        }
        return redirect()->to(route('student.home'))->with('error', 'Operation failed.');
    }

}
