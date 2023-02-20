<?php

namespace App\Providers;

use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $mail = DB::table('app_settings')->first();
        $config = array(
                    'driver'     => $mail->MAIL_MAILER,
                    'host'       => $mail->MAIL_HOST,
                    'port'       => $mail->MAIL_PORT,
                    'from'       => array('address' => $mail->MAIL_FROM_ADDRESS, 'name' => $mail->MAIL_FROM_NAME),
                    'encryption' => $mail->MAIL_ENCRYPTION,
                    'username'   => $mail->MAIL_USERNAME,
                    'password'   => $mail->MAIL_PASSWORD,
                    'sendmail'   => '/usr/sbin/sendmail -bs',
                    'pretend'    => false,
            );
        Config::set('mail', $config);
    }
}
