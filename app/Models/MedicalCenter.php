<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalCenter extends Model
{
    use HasFactory;
    protected $table='labmed';
    protected $fillable=['addr','namee','fulladd','phone','fax'];
    public $timestamps=false;
    public function getlabname(){
        return $this->hasOne(Task::class);
    }
    public function getlabnamepending(){
        return $this->hasOne(Requested::class);
    }
    public static function addnewcenter(Request $request)
    {
        $center=new MedicalCenter();
        $center->addr=$request->input('addr');
        $center->namee=$request->input('name');
        $center->fulladd=$request->input('fulladdr');
        $center->phone=$request->input('phone');
        $center->fax=$request->input('fax');
        $center->save();
        return back()->with('err','Medical center has been added');
    }

    public static function editMedicalcenter(Request $request){
        $Md=MedicalCenter::find($request->id);
        $Md->addr=$request->edtaddr;
        $Md->namee=$request->edtname;
        $Md->fulladd=$request->edtfulladdr;
        $Md->phone=$request->edtphone;
        $Md->fax=$request->edtfax;
        $Md->update();
        return back()->with('err','Medical center has been updated successfully.');
    }

    public static function deleteMdCenter($id){
        $r=Requested::with('getpendinglab')->where('labmed', $id)->count();
        $t=Task::with('getlabmed')->where('labmed', $id)->count();
        if($r==0 && $t==0){
            $md=MedicalCenter::find($id);
            $md->delete();
            return back()->with('err','Medical center has been deleted successfully.');
        }
        else
            return back()->with('cannotdelete','Cannot delete this medical center');
    }

}
