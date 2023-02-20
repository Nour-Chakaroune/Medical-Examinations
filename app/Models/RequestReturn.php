<?php

namespace App\Models;

use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Requested;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReturnedReqEmail;

class RequestReturn extends Model
{
    use HasFactory;
    protected $table='requestreturn';
    protected $fillable=['serial','type','pat','status','labmed','date','reason','image','imageType','userId'];

    public function getlabmedOn(){
        return $this->hasOne(MedicalCenter::class,'id','labmed');
    }
    public function getBeneficiarynameOn(){
        return $this->hasOne(Beneficiary::class,'id','pat');
    }
    public function getTypeOn(){
        return $this->hasOne(Tests::class,'id','type');
    }
    public function getCustomerOn(){
        return $this->hasOne(Customer::class,'id','serial');
    }
    public function getUser(){
        return $this->hasOne(User::class,'id','userId'); //doctor
    }
    public function getUserInfo(){
        return $this->hasOne(User::class,'number','serial'); //universityprofessor
    }

    public static function RejectedOnline(Request $request){
        $task=Requested::find($request->id);
        $reqOn= new RequestReturn();
        $reqOn->serial=$task->serial;
        $reqOn->type=$task->type;
        $reqOn->pat=$task->pat;
        $reqOn->status='Returned';
        $reqOn->labmed=$task->labmed;
        $reqOn->date=$task->date;
        $reqOn->reason=$request->reason;
        $reqOn->image=$task->image;
        $reqOn->imageType=$task->imageType;
        $date = new DateTime('now');
        $date->setTimezone(new DateTimeZone('Asia/Beirut'));
        $reqOn->created_at=$date->format('Y-m-d H:i:s');
        $reqOn->updated_at=$date->format('Y-m-d H:i:s');
        $reqOn->userId = Auth::User()->id;
        $reqOn->save();
        $task->delete();

        $mailData = [
            'title' => 'Your request has been returned',
            'body' => $reqOn->getUserInfo->fullname,
        ];
        $reason = $request->reason;
        Mail::to($reqOn->getUserInfo->email)->send(new ReturnedReqEmail($mailData,$reason));

        return back()->with('err','Record has been Returned.');
    }
}
