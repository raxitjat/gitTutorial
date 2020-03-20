<?php

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
    return view('welcome');
});

Auth::routes();
Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::middleware('auth')->group(function(){

    Route::get('post/dataTable', 'PostController@dataTable')->name('postDatatable');
    Route::resource('post','PostController');
});

Route::get('send-mail','PostController@sendMail')->name('sendMail');


// Route::get('admin-panel',function(){
//     return view('admin.layouts.default');
// });
Route::prefix('admin-panel')->group(function () {
    Route::get('/', function () {
    return view('admin.layouts.default');
        
    });
    Route::get('/dashboard', function () {
        return view('admin.user.demoData');
            
        });
});