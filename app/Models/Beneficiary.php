<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Beneficiary extends Model
{
    use HasFactory;
    protected $table='benef';
    protected $fillable=['Teacher_ID','PID','NAME','DOB','MARSTAT','DateEndIstifada'];
    public $timestamps=false;

    public function getbeneficiaryname(){
       return $this->hasOne(Task::class);
    }
    public static function getBeneficiaryBySerial(Request $request){
        return Beneficiary::where('Teacher_ID',$request->serial)->get();
    }
    public function getpendingbenefname(){
        return $this->hasOne(Requested::class);
    }
}
