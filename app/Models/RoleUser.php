<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    use HasFactory;
    protected $table='roleuser';
    protected $fillabe=['userId' , 'roleId'];
    public $timestamps=false;

    public function getUser(){
        return $this->hasOne(User::class,'id','userId');
    }
    public function getRole(){
        return $this->hasOne(Role::class,'id','roleId');
    }

    public static function deleteRole($id){
        $task=RoleUser::find($id);
        $c=RoleUser::Where('userId',$task->userId)->count();
        if($c==1){
            return back()->with('cannotdelete','Cannot delete the last role. Please add another role before delete.');
        }
        else{
            if($task->roleId == 4){
                $u=User::where('id',$task->userId)->first();
                $u->number=null;
                $u->save();
            }
            if($task->roleId == 1)
                user_permission::Where('userId',$task->userId)->Where('role','Admin')->delete();

            if($task->roleId == 2){
                $ex=RoleUser::Where('userid',$task->userId)->where('roleId',3)->first();
                    if (is_null($ex))
                        user_permission::Where('userId',$task->userId)->whereIn('role', ['Doctor', 'DoctorSecretary'])->delete();
                    else
                    user_permission::Where('userId',$task->userId)->Where('role','Doctor')->delete();
            }
            if($task->roleId == 3){
                $ex=RoleUser::Where('userid',$task->userId)->where('roleId',2)->first();
                    if (is_null($ex))
                        user_permission::Where('userId',$task->userId)->whereIn('role', ['Secretary', 'DoctorSecretary'])->delete();
                    else
                    user_permission::Where('userId',$task->userId)->Where('role','Secretary')->delete();
            }
            $task->delete();
            return back()->with('err','Role has been deleted successfully.');
        }
    }

    public static function addRole(Request $request){
        if($request->role !=""){
            foreach($request->role as $t){
                if($t==4)
                {
                    $request->validate([
                        'SerialNumber' => 'required|unique:users,number',
                    ],
                    [
                        'SerialNumber.required' => 'University professor must have a serial number',
                    ]);

                    $u=User::find($request->uid);
                    $u->number=$request->SerialNumber;
                    $u->save();
                }
                $ru = new RoleUser();
                $ru->roleId = $t;
                $ru->userId =$request->uid;
                $ru->save();

                //Admin
                if($t==1){
                    $p=permission::where('role','Admin')->get();
                    foreach($p as $addp){
                        $up= new user_permission();
                        $up->userId=$request->uid;
                        $up->permissionId=$addp->id;
                        $up->role=$addp->role;
                        $up->save();
                    }
                }
                //Doctor
                if($t==2){
                    $p=permission::whereIn('role', ['Doctor', 'DoctorSecretary'])->get();
                    foreach($p as $addp){
                        $up= new user_permission();
                        $up->userId=$request->uid;
                        $up->permissionId=$addp->id;
                        $up->role=$addp->role;
                        $ex=user_permission::Where('userid',$request->uid)->where('permissionId',$addp->id)->first();
                        if (is_null($ex))
                            $up->save();
                    }
                }
                //Secretary
                if($t==3){
                    $p=permission::whereIn('role', ['Secretary', 'DoctorSecretary'])->get();
                    foreach($p as $addp){
                        $up= new user_permission();
                        $up->userId=$request->uid;
                        $up->permissionId=$addp->id;
                        $up->role=$addp->role;
                        $ex=user_permission::Where('userid',$request->uid)->where('permissionId',$addp->id)->first();
                        if (is_null($ex))
                            $up->save();
                    }
                }
            }


            return back()->with('err','Role has been added successfully.');
        }
        else
            return back();
    }
}
