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

// scieżki uruchamiające funkcjonalnosci dotyczące maszyny
Route::post('/add_machine', 'MachineController@add_machine');
Route::get('/delete_machine/{id}', 'MachineController@delete');
Route::get('/edit/{id}', 'MachineController@edit');
Route::post('/update', 'MachineController@update');
