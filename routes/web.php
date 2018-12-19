<?php

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
    return view('auth/login');
});

// sciezki odpowiadające za autoryzacje (rejestracje, logowanie, wylogowanie)
Auth::routes();

// scieżki uruchamiające funkcjonalnosci dotyczące użytkownika
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile', 'UserController@profile')->name('profile');
Route::post('/change_pass', 'UserController@change_password');
Route::get('/delete_user/{id}', 'UserController@delete');
Route::get('/destroy', 'UserController@destroy');

// scieżki uruchamiające funkcjonalnosci dotyczące maszyny
Route::get('/archive', 'MachineController@archive');
Route::get('/machine_users/{id}', 'MachineController@users');
Route::get('/item/{id}', 'MachineController@item');
Route::get('/search', 'MachineController@search');
Route::get('/archive_search', 'MachineController@archive_search');
Route::post('/add_machine', 'MachineController@add_machine');
Route::post('/change_status', 'MachineController@change_status');
Route::get('/delete_machine/{id}', 'MachineController@delete');
Route::get('/edit/{id}', 'MachineController@edit');
Route::post('/separate_user', 'MachineController@separate_user');
Route::post('/update', 'MachineController@update');
Route::post('/assign_user', 'MachineController@assign_user');


