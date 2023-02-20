<?php

namespace App\Models;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class Tests extends Model
{
    use HasFactory;
    protected $table='testname';
    protected $filable=['name','type'];
    public $timestamps=false;
    public function getType(){
        return $this->hasOne(Task::class);
    }
    public function getTypepending(){
        return $this->hasOne(Requested::class);
    }
    public function getname($id){
        return Tests::where('id',$id)->get('name');
    }
    public static function addNewTest(Request $request)
    {
        $test=new Tests();
        $test->name=$request->input('testname');
        $test->type=$request->input('type');
        $test->save();
        return back()->with('err','Test has been added');
    }

    public static function edtTest(Request $request){
        $task=Tests::find($request->id);
        $task->name = $request->edttestname;
        $task->type = $request->edttype;
        $task->update();
        return back()->with('err','Test has been updated successfully.');
    }

    public static function deleteTest($id){
        $task=Tests::find($id);
        $task->delete();
        return back()->with('err','Test has been deleted successfully.');
    }
}
