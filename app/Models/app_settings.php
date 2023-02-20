<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class app_settings extends Model
{
    use HasFactory;
    protected $table='app_settings';
    protected $fillable=['MAIL_MAILER','MAIL_HOST','MAIL_PORT','MAIL_USERNAME','MAIL_PASSWORD','MAIL_ENCRYPTION','MAIL_FROM_ADDRESS','MAIL_FROM_NAME'];
    public $timestamps=false;

    public static function updateSettings(Request $request){
        $mail=app_settings::first();
        $mail->MAIL_MAILER=$request->mailer;
        $mail->MAIL_HOST=$request->host;
        $mail->MAIL_PORT=$request->port;
        $mail->MAIL_FROM_ADDRESS=$request->from_address;
        $mail->MAIL_FROM_NAME=$request->from_name;
        $mail->MAIL_ENCRYPTION=$request->encryption;
        $mail->MAIL_USERNAME=$request->user_name;
        $mail->MAIL_PASSWORD=$request->password;
        $mail->update();
        return back()->with('err','Mail has been updated successfully.');
    }
}
