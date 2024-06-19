<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Config;
use App\Models\Students;
use App\Models\User;
// use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use \Cookie;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class CustomLoginController extends Controller
{
    public function __construct(){
        $this->middleware('guest:web', ['except'=>['logout']]);
    }

    public function showLoginForm(){
        $data['help_contacts'] =  \App\Models\School::first()->help_contacts??'';
        $admission = Config::where('year_id', Helpers::instance()->getCurrentAccademicYear())->whereNotNull('start_date')->whereNotNull('end_date')->first();
        $year = Batch::find(Helpers::instance()->getCurrentAccademicYear());
        if($admission != null){
            if(now()->isBetween($admission->start_date, $admission->end_date)){
                $data['announcement'] = "Application into BIAKA University Institute open For ".($year->name??'').", From ".$admission->start_date->format('d/m/Y')." to ".$admission->end_date->format('d/m/Y');
            }elseif(now()->isBefore($admission->start_date)){
                $data['announcement'] = "Application into BIAKA University Institute opening For ".($year->name??'')." From ".$admission->start_date->format('d/m/Y')." to ".$admission->end_date->format('d/m/Y');
            }else{
                $data['announcement'] = "Application into BIAKA University Institute closed For ".($year->name??'');
            }
        }else {
            $data['announcement'] = "Application into BIAKA University Institute has not been opened For ".($year->name??'');
        }
        // dd($data);
        return view('auth.login', $data);
    }
    
     public function registration(){
        return $this->registration();
    } 

    public function showRegistrationForm()
    {
        # code...
        $data['help_contacts'] =  \App\Models\School::first()->help_contacts??'';
        $admission = Config::where('year_id', Helpers::instance()->getCurrentAccademicYear())->whereNotNull('start_date')->whereNotNull('end_date')->first();
        $year = Batch::find(Helpers::instance()->getCurrentAccademicYear());
        if($admission != null){
            if(now()->isBetween($admission->start_date, $admission->end_date)){
                $data['announcement'] = "Application into BIAKA University Institute open For ".($year->name??'').", From ".$admission->start_date->format('d/m/Y')." to ".$admission->end_date->format('d/m/Y');
            }elseif(now()->isBefore($admission->start_date)){
                $data['announcement'] = "Application into BIAKA University Institute opening For ".($year->name??'')." From ".$admission->start_date->format('d/m/Y')." to ".$admission->end_date->format('d/m/Y');
            }else{
                $data['announcement'] = "Application into BIAKA University Institute closed For ".($year->name??'');
            }
        }else {
            $data['announcement'] = "Application into BIAKA University Institute has not been opened For ".($year->name??'');
        }
        // dd($data);
        return view('auth.registration', $data);
    }

    public function check_matricule(Request $request){
       if (Students::where('matric', $request->reg_no)->exists()) { 
              if (User::where('username', $request->reg_no)->exists()) {   
                 return redirect()->route('registration')->with('error','Matricule Number has being used already. Contact the System Administrator.');   
              }else{
                $data['student_d'] = Students::where('matric', $request->reg_no)->first(); 
                $data['help_contacts'] =  \App\Models\School::first()->help_contacts??'';
                $admission = Config::where('year_id', Helpers::instance()->getCurrentAccademicYear())->whereNotNull('start_date')->whereNotNull('end_date')->first();
                $year = Batch::find(Helpers::instance()->getCurrentAccademicYear());
                if($admission != null){
                    if(now()->isBetween($admission->start_date, $admission->end_date)){
                        $data['announcement'] = "Application into BIAKA University Institute open For ".($year->name??'').", From ".$admission->start_date->format('d/m/Y')." to ".$admission->end_date->format('d/m/Y');
                    }elseif(now()->isBefore($admission->start_date)){
                        $data['announcement'] = "Application into BIAKA University Institute opening For ".($year->name??'')." From ".$admission->start_date->format('d/m/Y')." to ".$admission->end_date->format('d/m/Y');
                    }else{
                        $data['announcement'] = "Application into BIAKA University Institute closed For ".($year->name??'');
                    }
                }else {
                    $data['announcement'] = "Application into BIAKA University Institute has not been opened For ".($year->name??'');
                }
                // dd($data);  
                return view('auth.registration_info',$data);
              }
            
          }
          else{
            return redirect()->route('registration')->with('error','Invalid Registration Number.');   
          }
    }
    
    
    public function createAccount(Request $request){
        // dd($request->all());
        if (($stud = Students::where('matric', $request->username)->first()) != null) {  
            $update['phone'] = $request->phone;
            $update['password'] = Hash::make($request->password);
            
            $stud->update($update);
             if (User::where('username', $request->username)->exists()) {  
                $update1['name'] = $request->name;
                // $update1['email'] = $request->email;
                $update1['username'] = $request->username;
                $update1['type'] = 'student';
                $update1['password'] = Hash::make($request->password);
                
                $up1 = User::where('username', $request->username)->update($update1);
                auth('student')->login($stud);
                return redirect()->to(route('student.home'))->with('s','Account created successfully.'); 

            }else{
                $insert['name'] = $request->name;
                // $insert['email'] = $request->email;
                $insert['username'] = $request->username;
                $insert['type'] = 'student';
                $insert['gender'] = '';
                $insert['password'] = Hash::make($request->password);
            
                $up2 = User::create($insert);
                auth()->login($up2);
                return redirect()->to(route('admin.home'))->with('s','Account created successfully.'); 
            }
        //      if( Auth::guard('student')->attempt(['matric'=>$request->username,'password'=>$request->password], $request->remember)){
        //     // return "Spot 1";
        //     return redirect()->intended(route('student.home'));
        // }else{
        //     return redirect()->route('login')->with('s','Account created successfully.');   
        // }
            
            return redirect()->route('login')->with('s','Account created successfully.');   
            //return redirect()->route('student.home')->with('s','Account created successfully.');   
            
          }
          
    }

    public function detail(Request $request){
        $type = Cookie::get('iam');
        $user = Cookie::get('iamuser');
        $data['type'] = $type;

        if($type != '' && $user != ''){
            if($type == 0){
                $data['user'] = \App\StudentInfo::find($user);
        }else{
                $data['user'] = \App\Teacher::find($user);
        }
            return view('auth.register')->with($data);
        }else{
            return redirect()->route('register');
        }
    }

    public function login(Request $request){
         //return $request->all();
        //validate the form data
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required|min:2'
        ]);
        //return $request->all();
        //Attempt to log the user in

        // return $request->all();
        if( (Auth::guard('student')->attempt(['phone'=>$request->username,'password'=>$request->password], $request->remember))){
            // return "Spot 1";
            return redirect()->intended(route('student.home'));
        }else{
            if( Auth::attempt(['username'=>$request->username,'password'=>$request->password]) ||  Auth::attempt(['matric'=>$request->username,'password'=>$request->password])){
                return redirect()->route('admin.home')->with('success','Welcome to Admin Dashboard '.Auth::user()->name);
            }
        }
        // return "Spot 3";
        $request->session()->flash('error', 'Invalid Username or Password');
        return redirect()->route('login')->withInput($request->only('username','remember'));
    }

    public function logout(Request $request){
        Auth::logout();
        Auth::guard('student')->logout();
        return redirect(route('login'));
    }

}
