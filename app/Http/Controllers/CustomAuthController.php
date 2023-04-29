<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RoleUser;
use App\Models\user_permission;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;

class CustomAuthController extends Controller
{


    public function index()
    {
        return view('auth.login');
    }

    public function customLogin(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ],
    [
        'name.required'=>'Please enter username',
        'password.required'=>'Please enter your password',
    ]
    );

        if (Auth::attempt(['username'=>$request->name,'password'=>$request->password])) {
            if (Auth::User()->active ==1){
                $permissions=user_permission::where('userId',Auth::User()->id)->pluck('id','permissionId');
                if($permissions ->isEmpty())
                    return back()->withErrors('You have not permission to use this system');
                else{
                        //Session(['permission'=>$permissions]);
                        Session()->put('permission',$permissions);
                        return redirect()->intended('dashboard')
                                ->withSuccess('Signed in');
                }

            }
            else
            return back()->withErrors('You are not allowed to login');

        }

        else{
        return back()->withErrors('Login details are not valid');
    }
    }
    public function dashboard()
    {
            return view('Admin.dashboard');
      }

    public function signOut() {
        Auth::logout();

        return Redirect('login');
    }
}
