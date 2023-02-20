<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use App\Models\Customer;
use App\Models\MedicalCenter;
use App\Models\Requested;
use App\Models\Task;
use App\Models\Tests;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\RequestReturn;
use App\Models\app_settings;
use App\Models\permission;
use App\Models\user_permission;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;

class Admin extends Controller
{
    public function getaccepted(){

            $task=Task::with('getlabmed')->with('getBeneficiaryname')->with('getType')->where('Status','Accepted')->get();
            return view('Admin.accepted',compact('task'));
    }


    public function getrejected(){
        $task=Task::with('getlabmed')->with('getBeneficiaryname')->with('getType')->where('Status','Rejected')->get();
        return view('Admin.rejected',compact('task'));
    }


    public function getpending(){
        $task=Requested::with('getpendinglab')->with('getpendingbenef')->with('getcustomerpending')->with('getUser')->where('Status','Requested')->get();
        $labmed=MedicalCenter::all();
        $tests=Tests::all();
        return view('Admin.pending',compact('task','labmed','tests'));
    }


    public function getlast($id)
    {
        $task=Requested::find($id);
        $last=array();
        foreach(json_decode($task->type) as $key)
        {
            $lst=Task::where(['cust'=>$task->serial,'type'=>$key])->get();
            foreach($lst as $key1){
                $ls=[];
                $labmed=MedicalCenter::find($key1->labmed);
                $benef=Beneficiary::find($key1->benef);
                $ls=['cust'=>$key1->cust,'labmed'=>$labmed->namee,'benef'=>$benef->NAME,'type'=>$key1->type,'status'=>$key1->Status,'date'=>$key1->created_at];
                array_push($last,$ls);
            }
        }
        $last=json_encode($last);
        return view('Admin.last',compact('last'));
    }


    public function newtask(){
        $tests=Tests::all();
        $labmed=MedicalCenter::all();
        return view('Admin.newtask',compact('tests','labmed'));
    }


    public function check(Request $request){
      $serial=$request->input('serial');
      $request->validate([
        'serial'=>'required'
      ]);
      $customer=Customer::where('serial',$request->input('serial'))->count();
      if($customer>0){
        $benef=Beneficiary::where('Teacher_ID',$request->input('serial'))->orderBy('NAME')->get();
        return redirect()->back()->withInput($request->input())->with(compact('benef'));
      }
      else return back()->withErrors(['serial'=>'Serial number not found']);
    }


    public function setnewtask(Request $request){
      $request->validate([
        'serial'=>'required',
        'benef'=>'required',
        'test'=>'required|array',
        'labmed'=>'required',
        'date'=>'required|date',
        'image'=>'required|max:1000'
    ],
    [
      'serial.required' => 'The serial number is required.',
      'benef.required' => 'The patient name is required.',
      'test.required' => 'Please specify tests.',
      'labmed.required' => 'Please specify medical center.',
      'date.required' => 'Please select date to your request.',
      'image.required' => 'Please upload an image of the medical examinations.'
    ]);
      $benef=Beneficiary::where('Teacher_ID',$request->input('serial'))->orderBy('NAME')->get();
      return Requested::newtask($request);
    }


    public function editPending(Request $request){
      $request->validate([
        'benef'=>'required',
        'test'=>'required|array',
        'labmed'=>'required',
        'date'=>'required|date',
        'image'=>'max:1000'
        ],
        [
        'benef.required' => 'The patient name is required.',
        'test.required' => 'Please specify tests.',
        'labmed.required' => 'Please specify medical center.',
        'date.required' => 'Please select date to your request.',
        ]);
        return Requested::editpending($request);
    }

    public function deletePending($id){
      return Requested::deletepending($id);
    }


    public function pendingresult($id,Request $request){
      return Requested::result($id,$request);
    }


    public function print($id){
      if(Route::current()->getName()=='printpending')
      {
        $task=Requested::where('id',$id)->with('getpendinglab')->with('getpendingbenef')->get();
        return view('Admin.print',compact('task'));
      }
      elseif(Route::current()->getName()=='printaccepted')
      {
        $tsk=Task::where('id',$id)->with('getlabmed')->with('getBeneficiaryname')->first();
        $task=Task::where(['cust'=>$tsk->cust,'benef'=>$tsk->benef,'created_at'=>$tsk->created_at])->get(); //acc/rej
        return view('Admin.print',compact('task','tsk'));
      }
    }


    public function dailytask(){
        $requested=Requested::with('getpendinglab')->with('getpendingbenef')->with('getcustomerpending')->whereRaw('Date(created_at) = CURDATE()')->Where('status','Requested')->get();
        $task=Task::with('getlabmed')->with('getBeneficiaryname')->whereRaw('Date(created_at) = CURDATE()')->get();
        return view('Admin.daily',compact('requested','task'));
    }


    public function findtask(){
        $task=Task::with('getlabmed')->with('getBeneficiaryname')->get();
        return view('Admin.find',compact('task'));
    }


    public function searchtask(Request $request){
        $from=$request->input('fromdate');
        $to=$request->input('todate');
        if($to==null)
            $to=now();
        $task2=Task::whereBetween('date',[$from, $to])->with('getlabmed')->with('getBeneficiaryname')->get();
        return redirect()->back()->withInput($request->input())->with(['task2' => $task2]);
    }


    public function addMedicalCenter(Request $request)
    {
      $request->validate([
        'name'=>'required',
        'addr'=>'required',
        'fulladdr'=>'required',
        'phone'=>'required|unique:labmed,phone',
        'fax'=>'required|unique:labmed,fax',
      ],
      [
        'name.required'=>'Please enter medical center name',
        'addr.required'=>'Please select medical center address',
        'fulladdr.required'=>'Please enter medical center full address',
        'phone.required'=>'Please enter medical center phone',
        'fax.required'=>'Please enter medical center fax',
      ]);
        return MedicalCenter::addnewcenter($request);
    }


    public function addNewTest(Request $request)
    {
      $request->validate([
        'testname'=>'required|unique:testname,name',
        'type'=>'required'
      ],
    [
      'testname.required'=>'Please enter test name',
      'type.required'=>'Please select the test type',

    ]);
      return Tests::addNewTest($request);
    }

    public function listTest(){
            $tests=Tests::all();
            return view('admin.lstTest',compact('tests'));
    }

    public function editTest(Request $request){
        $request->validate([
            'edttestname'=>'required|unique:testname,name,'.$request->id,
            'edttype'=>'required'
          ],
        [
          'edttestname.required'=>'Please enter test name',
          'edttype.required'=>'Please enter test type',

        ]);
          return Tests::edtTest($request);
    }

    public function deleteTest($id){
        return Tests::deleteTest($id);
    }

    public function listMdlCenter(){
        $Mds=MedicalCenter::all();
        return view('admin.lstMdCenters',compact('Mds'));
    }

    public function editMdCenter(Request $request){
        $request->validate([
            'edtname'=>'required',
            'edtaddr'=>'required',
            'edtfulladdr'=>'required',
            'edtphone'=>'required|unique:labmed,phone,'.$request->id,
            'edtfax'=>'required|unique:labmed,fax,'.$request->id,
          ],
        [
          'edtname.required'=>'Please enter medical center name',
          'edtaddr.required'=>'Please select medical center address',
          'edtfulladdr.required'=>'Please enter medical center full address',
          'edtphone.required'=>'Please enter medical center phone',
          'edtfax.required'=>'Please enter medical center fax',
        ]);
          return MedicalCenter::editMedicalcenter($request);
    }

    public function deleteMdCenter($id){
        return MedicalCenter::deleteMdCenter($id);
    }

    public function getwaitingtask(){
        $task=Requested::with('getpendinglab')->with('getpendingbenef')->with('getcustomerpending')->where('Status','Waiting')->get();
        $labmed=MedicalCenter::all();
        $tests=Tests::all();
        return view('Admin.waiting',compact('task','labmed','tests'));
    }

    public function useraccepted($id){
        return Requested::useraccepted($id);
    }

    public function RejectedOnline(Request $request){
        return RequestReturn::RejectedOnline($request);
    }
    public function getRejectedOnline(){
        $task=RequestReturn::all();
        return view('Admin.rejectedOnline', compact('task'));
    }



    public function registration()
    {
        $roles=Role::all();
        return view('Admin.registration',compact('roles'));
    }

    public function addNewUser(Request $request)
    {
        if($request->role!=null)
            foreach($request->role as $k)
                if($k==4)
                {
                    $request->validate([
                        'name' => 'required',
                        'email' => 'required|email|unique:users,email',
                        'password' => 'required',
                        'username' =>'required|unique:users,username',
                        'phone' => 'required|unique:users,phone',
                        'number' =>'required|unique:users,number',
                    ]);
                }
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role' => 'required',
            'username' =>'required|unique:users,username',
            'phone' => 'required|unique:users,phone',
            ],
        );
        $data = $request->all();
        $check = $this->create($data);
        $x = User::Where('username',$request->username)->first();
        foreach($request->role as $r){
            $ru = new RoleUser();
            $ru->roleId = $r;
            $ru->userId =$x->id;
            $ru->save();
            //Admin
            if($r==1){
                $p=permission::where('role','Admin')->get();
                foreach($p as $addp){
                    $up= new user_permission();
                    $up->userId=$x->id;
                    $up->permissionId=$addp->id;
                    $up->role=$addp->role;
                    $up->save();
                }
            }
            //Doctor
            if($r==2){
                $p=permission::whereIn('role', ['Doctor', 'DoctorSecretary'])->get();
                foreach($p as $addp){
                    $up= new user_permission();
                    $up->userId=$x->id;
                    $up->permissionId=$addp->id;
                    $up->role=$addp->role;
                    $ex=user_permission::Where('userid',$x->id)->where('permissionId',$addp->id)->first();
                    if (is_null($ex))
                        $up->save();
                }
            }
            //Secretary
            if($r==3){
                $p=permission::whereIn('role', ['Secretary', 'DoctorSecretary'])->get();
                foreach($p as $addp){
                    $up= new user_permission();
                    $up->userId=$x->id;
                    $up->permissionId=$addp->id;
                    $up->role=$addp->role;
                    $ex=user_permission::Where('userid',$x->id)->where('permissionId',$addp->id)->first();
                    if (is_null($ex))
                        $up->save();
                }
            }
        }
        $mailData = [
            'title' => 'Your Registered Account',
            'body' => $request->name,
            'username' => $request->username,
            'password' => $request->password,

        ];
        Mail::to($request->email)->send(new SendEmail($mailData));
        return back()->with('err','User has been added successfully.');
    }

    public function create(array $data)
    {

      return User::create([
        'fullname' => $data['name'],
        'email' => $data['email'],
        'username' =>$data['username'],
        'password' => Hash::make($data['password']),
        'username' =>$data['username'],
        'number' =>$data['number'],
        'phone' =>$data['phone'],
        'active' => true,
      ]);
    }

    public function listStaffs(){
         $us=RoleUser::select('userId')->groupBy('RoleUser.userId')->join('Users', 'RoleUser.userId', '=', 'Users.id')->orderBy('Users.fullname', 'asc')->where('RoleUser.roleId','!=',4)->get();
         $roles=Role::all();
         $msg = "Staffs";
         return view('admin.lstStaffs',compact('us','roles', 'msg'));
     }

    public function listUsers(){
        $us=RoleUser::join('Users', 'RoleUser.userId', '=', 'Users.id')->orderBy('Users.fullname', 'asc')->where('RoleUser.roleId','=',4)->get();
        $roles=Role::all();
        $msg="University Professors";
        return view('admin.lstStaffs',compact('us','roles','msg'));
    }

    public function editUser($id){
        $u=User::find($id);
        $ur=RoleUser::Where('userId',$id)->get();
        $up=user_permission::Where('userId',$id)->get();
        return view('admin.editUser',compact('u','ur','up'));
    }

    public function editUserSave(Request $request){
        $request->validate([
            'fullname' => 'required',
            'email' => 'required|unique:users,email,'.$request->id,
            'phone' => 'required|unique:users,phone,'.$request->id,
            'username' =>'required|unique:users,username,'.$request->id,
            'number' => 'nullable|unique:users,number,'.$request->id,
        ]);
        return User::editUserSave($request);
    }

    //AccountUser
    public function accountUser(){
        return view('Admin.accountUser');
    }
    public function accountPass(){
        return view('Admin.accountPass');
    }
    public function changePass(Request $request){
        $request->validate([
            'oldpass' => 'required',
            'newpass' => 'required',
            'confirmpass' => 'required',
        ],
    );
        return User::changePass($request);
    }
    public function accountEdit(Request $request){
        $request->validate([
            'fullname' => 'required',
            'email' => 'required|unique:users,email,'.Auth::user()->id,
            'phone' => 'required|unique:users,phone,'.Auth::user()->id,
            'username' => 'required|unique:users,username,'.Auth::user()->id,
        ],
    );
        return User::accountEdit($request);
    }

    public function deleteRole($id){
        return RoleUser::deleteRole($id);
    }

    public function addRole(Request $request){
        return RoleUser::addRole($request);
    }

    public function deletePermission($id){
        return user_permission::deletePermission($id);
    }

    public function addPermission(Request $request){
        $request->validate([
            'permission' => 'required',
        ],
    );
        return user_permission::addPermission($request);
    }

    //Settings
    public function appSettings(){
        $mail = app_settings::first();
        return view('Admin.appSettings',compact('mail'));
    }
    public function updateSettings(Request $request){
        $request->validate([
            'user_name' => 'required',
            'password' => 'required',
            'from_address' => 'required',
            'from_name' => 'required',
            'mailer' => 'required',
            'host' => 'required',
            'port' => 'required',
            'encryption' => 'required',
        ]);
        return app_settings::updateSettings($request);
    }

  }
