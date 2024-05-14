<?php

namespace App\Http\Controllers\Auth;
use \Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Students;
use App\Mail\ResetEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
class CustomForgotPasswordController extends Controller
{

    private function sendResetEmail($email, $token)
    {
    $link = route('reset',[$token, urlencode($email)]);
    //dd($link);
        try {
            $data['email'] = $email;
            $data['link'] = $link;
                 Mail::to($email)->send(new ResetEmail($data));
            } catch (\Exception $e) {
           echo  ($e);
        }
        return true;  
    }

    public function validatePasswordRequest(Request $request)
    {
        $validator = Validator::make($request->all(), ['phone'=>'required']);
        if($validator->fails()){
            return back()->with('error', $validator->errors()->first());
        }

        $record = Students::where(['phone'=>$request->phone])->first();
        if($record != null){
            $record->password = \Illuminate\Support\Facades\Hash::make('12345678');
            $record->save();
            auth('student')->login($record);
            return redirect(route('student.home'))->with('success', "Done. New password 12345678");
        }
        return back()->with('error', __('text.missing_student'));
    }

    public function resetPassword(Request $request)
{
    
    //Validate input
    $validator = Validator::make($request->all(), [
        'email' => 'required',
        'token' => 'required',
        'password' => 'required|confirmed',
    ]);

    //check if input is valid before moving on
    if ($validator->fails()) {
        return redirect()->back()->withErrors(['email' => 'Please complete the form']);
    }
    

    $password = $request->password;// Validate the token
    $tokenData = \DB::table('password_resets')
    ->where('token', $request->token)->first();// Redirect the user back to the password reset request form if the token is invalid
    if (!$tokenData){
        $request->session()->flash('error', 'Invalid Password Reset Link');
        return view('auth.login');
    } 

    if($tokenData->type == 0){
        $user = User::where('email', $tokenData->email)->first();
        if (!$user) return redirect()->back()->withErrors(['email' => 'Email not found']);//Hash and update the new password
        $user->password = \Hash::make($password);
        $user->save();
        //login the user immediately they change password successfully
        \Auth::login($user);
    }else{
        $user = Students::where('email', $tokenData->email)->first();
        if (!$user) return redirect()->back()->withErrors(['email' => 'Email not found']);//Hash and update the new password
        $user->password = \Hash::make($password);
        $user->save();
        //login the user immediately they change password successfully
        \Auth::guard('student')->login($user);
    }
   
    //Delete the token
    \DB::table('password_resets')->where('email', $user->email)
    ->delete();
return redirect()->route('login')->with('s','Password Changed Successfully');
        // return redirect()->to(route('login'));

}

    public function resetForm($token, $email){
        //dd($email);
        $data['token'] = $token;
        $data['email'] = $email;
        return view('auth.passwords.reset')->with($data);
    }

    public function recover_username(Request $request)
    {
        $validity = Validator::make($request->all(), ['matric'=>'required']);
        if($validity->fails()){
            return back()->with('error', $validity->errors()->first());
        }
        $student = Students::where('matric', $request->matric)->first();
        if($student != null){
            if($student->username == null){
                return back()->with('error', __('text.no_username_registered_for_this_account'));
            }
            return back()->with('success', __('text.word_done'));
        }
        return back()->with('error', __('text.could_not_find_any_account_with_specified_matricule'));
    }
}
