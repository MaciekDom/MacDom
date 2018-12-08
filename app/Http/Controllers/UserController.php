<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;
use Auth;

class UserController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth'); // dostęp do funkcji w tym kontrolerze mają tylko zalogowani uzytkownicy
    }

    public function profile() // funkcja wyswietlająca profil uzytkownika
    {
        $id = Auth::id();
        $today = Carbon::today()->toDateString();
        $users = DB::table('users')->where("login",'!=','admin')->get();
        $machines = DB::table('machines')
            ->join('users_machines','id','=','id_machines')
            ->where('id_users',$id)->get();

        return view('profile',compact('today','machines','users'));
    }

    public function change_password(Request $request) // funkcja aktualizująca hasło uzytkownika
    {
        $id = Auth::id();

        if($request['pass']==$request['pass-conf']){
            if(strlen($request['pass'])<6){
                Session::flash('error', 'Hasło musi składać się z conajmniej 6 znaków!'); 
                return redirect()->back();
            }
            else{
                DB::table('users')->where('id', $id)->limit(1)->update(array('password' => bcrypt($request['pass'])));
                Session::flash('success', 'Poprawnie zaktualizowano hasło'); 
                $today = Carbon::today()->toDateString();
                return redirect()->back();
            }
        }
        else{
            Session::flash('error', 'Podane hasła nie są takie same!'); 
            return redirect()->back();
        }                
    }
}
