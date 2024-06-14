<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassMaster;
use App\Models\Matriculation;
use App\Models\Role;
use App\Models\TeachersSubject;
use App\Models\User;
use App\Models\UserRole;
use App\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // auth()->logout();
        $data['campuses'] = collect(json_decode($this->api_service->campuses())->data);
        if(\request()->has('role') || \request()->has('type')){
            $data['type'] = \request('role') ? \request('role') : \request('type');
            $data['title'] = "Role ".($data['type'] ?? " Users");
            if(\request()->has('role')){
                $data['users'] = Role::where('slug', '=', $request->role)->first()->users;
                    // ->get('users.*');
            }else{
                $data['users'] = \App\Models\User::where('type', request('type', 'teacher'))->get();
            }
            // dd($data['users']);
            return view('admin.user.index')->with($data);
        }else if(\request('permission')){
            $data['type'] = \App\Models\Permission::whereSlug(\request('permission'))->first()->name;
            $data['title'] = "Permission ".($data['type'] ?? "Users");
            $data['users'] =\App\Models\Permission::whereSlug(\request('permission'))->first()->users()->get();
            return view('admin.user.index')->with($data);
        }else{
            $data['type'] = request('teacher', 'user');
            $data['users'] = \App\Models\User::where('type', request('type', 'teacher'))->get();
            $data['title'] = "Manage " . $data['type']. 's';
            return view('admin.user.index')->with($data);
        }
    }

    public function create(Request $request)
    {
        $data['title'] = "Add ".(request('type') ?? "User");
        $data['campuses'] = collect(json_decode($this->api_service->campuses())->data);
        return view('admin.user.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'phone' => 'required',
            'address' => 'nullable',
            'campus' => 'nullable',
            'gender' => 'required',
            'type' => 'required',
        ]);
        $pattern = Matriculation::first();
        $pattern->last_number = $pattern->last_number+1;
        if(User::where('matric', $pattern->pattern . $pattern->last_number)->count() > 0){
            $pattern->last_number = $pattern->last_number+1;
        }
        $input = $request->all();
        $input['password'] = Hash::make('password');
        $input['username'] = $request->email;
        $input['campus_id'] = $request->campus ?? null;
        $input['matric'] = $pattern->pattern . str_pad($pattern->last_number, 4, '0', STR_PAD_LEFT); ;
        if($request->type == "teacher"){
            $input['type'] = "teacher";
        }else{
            $input['type'] = "admin";
        }
        $user = new \App\Models\User($input);
        $user->save();

        $pattern->save();
        if($request->type != "teacher"){
            $user_role = new \App\Models\UserRole();
            $user_role->role_id = Role::where('slug', $request->type)->first()->id;
            $user_role->user_id = $user->id;
            $user_role->save();
        }

        return redirect()->to(route('admin.users.index', [$request->type=='teacher' ? 'type' : 'role' =>$request->type]))->with('success', "User Created Successfully !");
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $data['title'] = "User details";
        $data['user'] = \App\Models\User::find($id);
        $data['courses'] = collect();
        // dd($data);
        return view('admin.user.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $data['title'] = "Edit user details";
        $data['campuses'] = collect(json_decode($this->api_service->campuses())->data);
        $data['user'] = \App\Models\User::find($id);
        return view('admin.user.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'nullable',
            'gender' => 'required',
            'type' => 'required',
        ]);
        $user = \App\Models\User::find($id);
        // if (\Auth::user()->id == $id || \Auth::user()->id == 1) {
        //     return redirect()->to(route('admin.users.index', ['type' => $user->type]))->with('error', "User can't be updated");
        // }

        // update users table
        $input = $request->all();
        // return $input;
        $user->update($input);

        // update User roles
        $role_id = $request->role_id;
        if(!$role_id == null){
            $user_role = $user->roleR->first();
            $user_role->role_id = $role_id;
            $user_role->save();
        }

        return redirect()->to(route('admin.users.show', [$user->id]))->with('success', "User updated Successfully !");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = \App\Models\User::find($id);
        if (\Auth::user()->id == $id || \Auth::user()->id != 1) {
            return redirect()->to(route('admin.users.index', ['type' => $user->type]))->with('error', "User can't be deleted");
        }
        $user->delete();
        return redirect()->to(route('admin.users.index', ['type' => $user->type]))->with('success', "User deleted successfully!");
    }


    public function createSubject($id)
    {
        $data['user'] = \App\Models\User::find($id);
        $data['title'] = "Assign Subject to " . $data['user']->name;
        $data['classes'] = StudentController::baseClasses();
        return view('admin.user.assignSubject')->with($data);
    }

    public function classmaster()
    {
        $data['users'] = \App\Models\ClassMaster::paginate(20);
        $data['title'] = "HOD";
        return view('admin.user.classmaster')->with($data);
    }

    public function classmasterCreate()
    {
        $data['title'] = "Assign HOD";
        $data['classes'] = StudentController::baseClasses();
        $data['units'] = \App\Models\SchoolUnits::where('parent_id', 0)->get();
        return view('admin.user.create_classmaster')->with($data);
    }

    public function saveClassmaster(Request  $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'campus_id' => 'required',
            'section' => 'required',
        ]);
        if (ClassMaster::where('user_id', $request->user_id)->where('department_id',  $request->section)->where('campus_id',  $request->campus_id)->count() > 0) {
            return redirect()->back()->with('error', "User already assigned to this class !");
        }

        $master = new ClassMaster();
        $master->user_id = $request->user_id;
        $master->campus_id = $request->campus_id;
        $master->department_id = $request->section;
        $master->batch_id = \App\Helpers\Helpers::instance()->getCurrentAccademicYear();
        $master->save();

        return redirect()->to(route('admin.users.classmaster'))->with('success', "User updated Successfully !");
    }

    public function  deleteMaster(Request  $request)
    {
        $master = ClassMaster::findOrFail($request->master);
        $master->delete();
        return redirect()->to(route('admin.users.classmaster'))->with('success', "User unassigned Successfully !");
    }


    public function dropSubject($id)
    {
        $s = TeachersSubject::find($id);
        if ($s) {
            $s->delete();
        }
        return back()->with('success', "Subject deleted successfully!");
    }

    public function saveSubject(Request $request, $id)
    {
        $subject = TeachersSubject::where([
            'teacher_id' => $id,
            'batch_id' => \App\Helpers\Helpers::instance()->getCurrentAccademicYear(),
            'subject_id' => $request->subject,
            'class_id' => $request->section,
            'campus_id' => $request->campus,
        ]);

        if ($subject->count() == 0) {
            TeachersSubject::create([
                'teacher_id' => $id,
                'subject_id' => $request->subject,
                'class_id' => $request->section,
                'campus_id' => $request->campus,
                'batch_id' => \App\Helpers\Helpers::instance()->getCurrentAccademicYear()
            ]);
            Session::flash('success', "Subject assigned successfully!");
        } else {
            Session::flash('error', "Subject assigned already");
        }

        return redirect()->to(route('admin.users.show', $id));
    }
}
