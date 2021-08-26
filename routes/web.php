<?php

use Illuminate\Support\Facades\Auth;
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


Route::get('/', function () {
    return view('auth.login');
});

Route::group(['prefix' => 'user','middleware' => ['auth']], function(){
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/profile', 'UserController@index')->name('user-profile');
    Route::get('/profile/edit/{id}', 'UserController@edit')->name('user-profile-edit');
    Route::post('/profile/update/{id}', 'UserController@update')->name('user-profile-update');
    Route::post('/profile/update/myprofile/{id}', 'UserController@updateMyProfile')->name('user-myprofile-update');

    Route::get('/profile/create', 'UserController@create')->name('user-create-profile');
    Route::get('/profile/reveral', 'UserController@createReveral')->name('user-create-reveral');
    Route::post('/profile/reveral/store/{id}', 'UserController@storeReveral')->name('user-store-reveral');

    Route::get('/member/download','UserController@memberReportPdf')->name('user-member-downloadpdf');


    Route::group(['prefix' => 'member'], function(){
        Route::get('index','UserController@indexMember')->name('member-index');
        Route::get('create','UserController@createNewMember')->name('member-create');
        Route::post('/profile/store', 'UserController@store')->name('user-store-profile');
        Route::get('show/mymember/{id}','UserController@profileMyMember')->name('member-mymember');
        Route::get('member/card/download/{id}','UserController@downloadCard')->name('member-card-download');

        Route::get('/referal/undirect','UserController@memberByUnDirectReferal')->name('member-undirect-referal');
        Route::get('/referal/direct','UserController@memberByDirectReferal')->name('member-direct-referal');

        Route::get('/registered/{id}','UserController@registeredNasdem');
        Route::get('/saved/{id}','UserController@savedNasdem');

    });


});

Route::group(['prefix' => 'admin','namespace' => 'Admin'], function(){
    Route::get('/login','LoginController@loginForm')->name('admin-login');
    Route::post('/login','LoginController@login')->name('post-admin-login');

    Route::group(['middleware' => 'admin'], function(){
        Route::post('logout','LoginController@logout')->name('admin-logout');
        Route::get('dashboard','DashboardController@index')->name('admin-dashboard');
        Route::get('dashboard/regency/{regency_id}','DashboardController@regency')->name('admin-dashboard-regency');
        Route::get('dashboard/regency/district/{district_id}','DashboardController@district')->name('admin-dashboard-district');

        Route::get('member','MemberController@index')->name('admin-member');
        Route::get('member/create','MemberController@create')->name('admin-member-create');
        Route::post('member/store','MemberController@store')->name('admin-member-store');

        Route::get('member/profile/{id}','MemberController@profileMember')->name('admin-profile-member');
        Route::get('member/profile/edit/{id}','MemberController@editMember')->name('admin-profile-member-edit');
        Route::post('member/profile/update/{id}','MemberController@updateMember')->name('admin-profile-member-update');

        // report excel
        Route::get('member/province/export','DashboardController@exportDataProvinceExcel')->name('report-member-province-excel');
        Route::get('member/regency/export/{regency_id}','DashboardController@exportDataRegencyExcel')->name('report-member-regency-excel');
        Route::get('member/district/export/{district_id}','DashboardController@exportDataDistrictExcel')->name('report-member-district-excel');

        Route::get('member/card/download/{id}','MemberController@downloadCard')->name('admin-member-card-download');

    });
});

Auth::routes();


