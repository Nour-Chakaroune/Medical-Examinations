<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_permission extends Model
{
    use HasFactory;
    protected $table='user_permission';
    protected $fillabe=['userId','permissionId','role','deadline'];
    public $timestamps=false;

    public function getPermission(){
        return $this->hasOne(permission::class,'id','permissionId');
    }

    public static function deletePermission($id){
        $per=user_permission::find($id);
        $per->delete();
        return back()->with('err','Permission has been deleted successfully.');
    }
    public static function addPermission(Request $request){
        foreach($request->permission as $addp){
            $f=permission::find($addp);
            $p= new user_permission();
            $p->userId=$request->uid;
            $p->permissionId=$addp;
            $p->deadline=$request->date;
            $p->role=$f->role;
            $p->save();
        }
        return back()->with('err','Permission has been deleted successfully.');
    }
}
