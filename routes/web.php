<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\CustomAuthController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom');
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');

//App::setLocale('ar');

Route::middleware(['auth'])->group(function () {

    Route::get('/', function(){ return redirect('dashboard'); });
    Route::get('/dashboard', [CustomAuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/account/user', [Admin::class, 'accountUser'])->name('accountuser');
    Route::post('/account/user', [Admin::class, 'accountEdit'])->name('accountedit');
    Route::get('/account/password', [Admin::class, 'accountPass'])->name('accountpass');
    Route::post('/change/password', [Admin::class, 'changePass'])->name('changepass');

    Route::middleware(['permissions:7'])->group(function () {
        Route::get('/task/accepted', [Admin::class, 'getaccepted'])->name('accepted');
        Route::get('/task/accepted/print/{id}', [Admin::class, 'print'])->name('printaccepted');
    });

    Route::middleware(['permissions:8'])->group(function () {
        Route::get('/task/rejected', [Admin::class, 'getrejected'])->name('rejected');
    });

    Route::middleware(['permissions:12'])->group(function () {
        Route::get('/task/pending', [Admin::class, 'getpending'])->name('pending');
        Route::get('/task/pending/last/{id}', [Admin::class, 'getlast'])->name('last');
        Route::get('/task/pending/print/{id}', [Admin::class, 'print'])->name('printpending');
        Route::post('/task/pending/result/{id}', [Admin::class, 'pendingresult'])->name('resulttask');
        Route::get('/task/pending/delete/{id}', [Admin::class, 'deletePending'])->name('deletetask');
        Route::post('/task/pending/edit', [Admin::class, 'editPending'])->name('edittask');
    });

    Route::middleware(['permissions:10'])->group(function () {
        Route::get('/task/daily', [Admin::class, 'dailytask'])->name('dailytask');
    });

    Route::middleware(['permissions:11'])->group(function () {
        Route::get('/task/find', [Admin::class, 'findtask'])->name('findtask');
        Route::post('/task/find', [Admin::class, 'searchtask'])->name('findtask');
    });

    Route::middleware(['permissions:5'])->group(function () {
        Route::get('/new/task', [Admin::class, 'newtask'])->name('newtask');
        Route::post('/new/task/check', [Admin::class, 'check'])->name('check');
        Route::post('/new/task/set', [Admin::class, 'setnewtask'])->name('setnewtask');
    });

    Route::middleware(['permissions:16'])->group(function () {
        Route::post('/add/test',[Admin::class, 'addNewTest'])->name('addNewTest');
        Route::get('/list/tests', [Admin::class, 'listTest'])->name('listtests');
        Route::post('/test/edit', [Admin::class, 'editTest'])->name('edittest');
        Route::get('/test/delete/{id}', [Admin::class, 'deleteTest'])->name('deletetest');
    });

    Route::middleware(['permissions:15'])->group(function () {
        Route::post('/add/medical/center',[Admin::class, 'addMedicalCenter'])->name('addMedicalCenter');
        Route::get('/list/medical/center', [Admin::class, 'listMdlCenter'])->name('listmedicalcenters');
        Route::post('/medicalcenter/edit', [Admin::class, 'editMdCenter'])->name('editmdcenter');
        Route::get('/medicalcenter/delete/{id}', [Admin::class, 'deleteMdCenter'])->name('deletemdcenter');
    });

    Route::middleware(['permissions:6'])->group(function () {
        Route::get('/task/waiting', [Admin::class, 'getwaitingtask'])->name('waitingtask');
        Route::get('/user/accepted/{id}', [Admin::class, 'useraccepted'])->name('useraccepted');
        Route::post('/return/online',[Admin::class, 'RejectedOnline'])->name('returnonline');
        Route::get('/task/waiting/last/{id}', [Admin::class, 'getlast'])->name('waitinglast');
    });

    Route::middleware(['permissions:9'])->group(function () {
        Route::get('/task/returned/online', [Admin::class, 'getRejectedOnline'])->name('returnedonline');
    });


    Route::middleware(['permissions:1'])->group(function () {
        Route::get('/register/user', [Admin::class, 'registration'])->name('registeruser');
        Route::post('/add/user',[Admin::class, 'addNewUser'])->name('addNewUser');
    });

    Route::middleware(['permissions:3'])->group(function () {
        Route::get('/list/users', [Admin::class, 'listUsers'])->name('listusers');
    });

    Route::middleware(['permissions:2'])->group(function () {
        Route::get('/list/staffs', [Admin::class, 'listStaffs'])->name('liststaffs');
    });

    Route::middleware(['permissions:2,3'])->group(function () {
        Route::get('/user/role/delete/{id}', [Admin::class, 'deleteRole'])->name('deleterole');
        Route::post('/user/addrole', [Admin::class, 'addRole'])->name('addRole');
        Route::get('/Users/edit/{id}', [Admin::class, 'editUser'])->name('editUser');
        Route::get('/Staffs/edit/{id}', [Admin::class, 'editUser'])->name('editStaff');
        Route::post('/user/edit/save', [Admin::class, 'editUserSave'])->name('editusersave');
        Route::get('/user/permission/delete/{id}', [Admin::class, 'deletePermission'])->name('deletepermission');
        Route::post('/user/addpermission', [Admin::class, 'addPermission'])->name('addPermission');
    });

    Route::middleware(['permissions:4'])->group(function () {
        Route::get('/app/settings', [Admin::class, 'appSettings'])->name('appsettings');
        Route::post('/app/settings/update', [Admin::class, 'updateSettings'])->name('updatesettings');
    });


});

