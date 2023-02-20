<?php

namespace App\Models;

use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Image;
use Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\InfoEmail;

class Requested extends Model
{
    use HasFactory;
    protected $table='request';
    protected $fillable=['serial','type','pat','status','labmed','date','image','imageType','userId'];

    public function getpendinglab(){
        return $this->hasOne(MedicalCenter::class,'id','labmed');
    }
    public function getpendingbenef(){
        return $this->hasOne(Beneficiary::class,'id','pat');
    }
    public function getcustomerpending(){
        return $this->hasOne(Customer::class,'id','serial');
    }
    public function getUser(){
        return $this->hasOne(User::class,'id','userId'); //doctor
    }
    public function getUserInfo(){
        return $this->hasOne(User::class,'number','serial'); //universityprofessor
    }


    public static function newtask(Request $request){
        $task=new Requested();
        $task->serial=$request->serial;
        $task->type=json_encode($request->test);
        $task->pat=$request->benef;
        $task->Status='Requested';
        $task->labmed=$request->labmed;
        $task->date=$request->date;
        $date = new DateTime('now');
        $date->setTimezone(new DateTimeZone('Asia/Beirut'));
        $task->created_at=$date->format('Y-m-d H:i:s');
        $task->updated_at=$date->format('Y-m-d H:i:s');

        if( $request->hasFile('image')) {
            $file = $request->file('image');
            $imageType = $file->getClientOriginalExtension();
            $height = Image::make($file)->height();
            $width = Image::make($file)->width();

            $image_resize = Image::make($file)->resize( $height, $width, function ( $constraint ) {
                                                                    $constraint->aspectRatio();
                                                                })->encode( $imageType );
            $task->imageType = $imageType;
            $task->image=$image_resize;
        }
        $task->userId=Auth::User()->id;
        $task->save();
        return back()->with('err','Record has been added successfully.');
    }

    public static function editpending(Request $request){
        $task=Requested::find($request->id);
        $task->type=json_encode($request->test);
        $task->pat=$request->benef;
        $task->labmed=$request->labmed;
        $task->date=$request->date;
        $date = new DateTime('now');
        $date->setTimezone(new DateTimeZone('Asia/Beirut'));
        $task->updated_at=$date->format('Y-m-d H:i:s');
        if( $request->hasFile('image')) {
            $file = $request->file('image');
            $imageType = $file->getClientOriginalExtension();
            $height = Image::make($file)->height();
            $width = Image::make($file)->width();

            $image_resize = Image::make($file)->resize( $height, $width, function ( $constraint ) {
                                                                    $constraint->aspectRatio();
                                                                })->encode( $imageType );
            $task->imageType = $imageType;
            $task->image=$image_resize;

        }
        $task->userId=Auth::User()->id;
        $task->update();
        return back()->with('err','Record has been updated successfully.');
    }
    public static function deletepending($id){
        $task=Requested::find($id);
        $task->delete();
        return back()->with('err','Record has been deleted successfully.');
    }

    public static function useraccepted($id){
        $task=Requested::find($id);
        $task->Status='Requested';
        $task->userId=Auth::User()->id;
        $task->save();
        return back()->with('err','Record Accepted');
    }

    public static function result($id,Request $request)
    {
        $requested=Requested::find($id);
        $acc=$request->input('acc');
        $arr1=explode('* ',$acc);
        $arr1=str_replace(array("\r\n","\r",""),"",$arr1);
        $accept=array();
        foreach($arr1 as $key)
        {
          if($key!='')
          {
            array_push($accept,$key);
          }
        }
        $rej=$request->input('rej');
        $arr2=explode('* ',$rej);
        $arr2=str_replace(array("\r\n","\r",""),"",$arr2);
        $reject=array();
        foreach($arr2 as $key)
        {
          if($key!='')
          {
            array_push($reject,$key);
          }
        }

        foreach($accept as $key)
        {
          $task=new Task();
          $task->labmed=$requested->labmed;
          $task->cust=$requested->serial;
          $task->benef=$requested->pat;
          $task->type=$key;
          $date = new DateTime('now');
          $date->setTimezone(new DateTimeZone('Asia/Beirut'));
          $task->created_at=$date->format('Y-m-d H:i:s');
          $task->updated_at=$date->format('Y-m-d H:i:s');
          $task->Status='Accepted';
          $task->date=date('Y-m-d');
          $task->userId=Auth::User()->id;
          $task->reqId=$id;
          $task->save();
        }
        foreach($reject as $key)
        {
          $task=new Task();
          $task->labmed=$requested->labmed;
          $task->cust=$requested->serial;
          $task->benef=$requested->pat;
          $task->type=$key;
          $date = new DateTime('now');
          $date->setTimezone(new DateTimeZone('Asia/Beirut'));
          $task->created_at=$date->format('Y-m-d H:i:s');
          $task->updated_at=$date->format('Y-m-d H:i:s');
          $task->Status='Rejected';
          $task->date=date('Y-m-d');
          $task->userId=Auth::User()->id;
          $task->reqId=$id;
          $task->save();
        }
        $mailData = [
            'title' => 'Your status request has been updated',
            'body' => $requested->getUserInfo->fullname,
        ];
        $res =Task::Where('reqId',$id)->get();
        Mail::to($requested->getUserInfo->email)->send(new InfoEmail($mailData,$res));

        $requested->delete();
        return back()->with('err','Result has been sent');
    }
}
