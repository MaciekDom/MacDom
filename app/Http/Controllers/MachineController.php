<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;
use Auth;

class MachineController extends Controller
{  

    public function __construct()
    {
        $this->middleware('auth'); // dostęp do funkcji w tym kontrolerze mają tylko zalogowani uzytkownicy
    }

    public function item($id) // funkcja uruchamiająca profil maszyny
    {
        $item = DB::table('machines')->where('id',$id)->get();
        $users = DB::table('users')
                ->join('users_machines','id_users','id')
                ->where('id_machines',$id)
                ->where('login','!=','admin')
                ->get();
        $today = Carbon::today()->toDateString();        

        return view('item',compact('item','users','today'));
    }

    public function users($id) // funkcja uruchamiająca stronę zarządzania użytkownikami maszyny
    {
        $machine = DB::table('machines')->where('id',$id)->get();
        $assigned_users = DB::table('users')
                ->join('users_machines','id_users','id')
                ->where('id_machines',$id)
                ->where('login','!=','admin')
                ->get();

        $free_users = DB::table('users')
                ->where('login','!=','admin')
                ->get();

        return view('users',compact('machine','assigned_users','free_users'));
    }

    public function assign_user(Request $request) // funkcja odpowiadająca za przypisywanie uzytkownika do maszyny
    {
        $check = DB::table('users_machines')
                    ->where('id_users',$request['user_id'])
                    ->where('id_machines',$request['machine_id'])
                    ->first();

        if($check == true){
            Session::flash('success', 'Użytkownik był już przypisany do maszyny'); 
        }
        else{
            $query = DB::table('users_machines')->insert([
             'id_users' => $request['user_id'],  
             'id_machines' => $request['machine_id'], 
            ]);
            Session::flash('success', 'Przypisano pracownika'); 
        }
        return redirect()->back();
    }

    public function separate_user(Request $request) 
    // funkcja odpowiedzialna za cofnięcie przypisania uzytkownika do maszyny
    {
        $query = DB::table('users_machines')
        ->where('id_users', $request['user_id'])
        ->where('id_machines', $request['machine_id'])
        ->delete();

        if($query == true){
            Session::flash('success', 'Wybrany użytkownik stracił prawa do tej maszyny'); 
        }
        else{
            Session::flash('error', 'Wystąpił nieoczekiwany błąd'); 
        }
        return redirect()->back();
    }

    public function add_machine(Request $request) // funkcja dodająca nową maszynę do bazy
    {
        $query = DB::table('machines')->insert([
         'name' => $request['name'],  
         'model' => $request['model'], 
         'company' => $request['company'],
         'image' => $request['image'],
         'description' => $request['description'],
         'status_desc' => 'Maszyna gotowa do pracy',
         'overwiew_date' => $request['date']
        ]);

        $user_id = Auth::id();
        $machine_id = DB::getPdo()->lastInsertId();

        $query2 = DB::table('users_machines')->insert([
         'id_users' => $user_id,  
         'id_machines' => $machine_id
        ]);

        if($query == true && $query2){
            Session::flash('success', 'Maszyna została dodana do systemu'); 
        }
        else{
            Session::flash('error', 'Wystąpił nieoczekiwany błąd'); 
        }
        $today = Carbon::today()->toDateString();
        return redirect()->back();
    }

    public function change_status(Request $request){ // funkcja zmieniająca status maszyny

        $id = Auth::id();

        $user = DB::table('users')->select('name')->where('id',$id)->value('name');

        $query = DB::table('machines')
                ->where('id',$request['id'])
                ->update([
                    'status'=>$request['status'],
                    'status_user'=>$user,
                    'status_desc'=>$request['description'],
                    'overwiew_date'=>$request['date']
                ]);

        if($query == true){

            DB::table('archive')->insert([
             'id_machines' => $request['id'],  
             'status' => $request['status'],
             'status_user' => $user,
             'status_desc' => $request['description'],
             'overwiew_date' => $request['date'],
             'created_at' => Carbon::now()
            ]); 

            Session::flash('success', 'Zaktualizowano status'); 
        }
        else{
            Session::flash('error', 'Wystąpił nieoczekiwany błąd'); 
        }
        return redirect()->back();
    }

    public function search(Request $request){ // funkcja wyszukująca maszynę

        $user_id = Auth::id();

        $machines = DB::table('machines')
            ->join('users_machines','id','=','id_machines')
            ->where('id_users',$user_id)
            ->where('name',$request['search'])
            ->orWhere('id_users',$user_id)
            ->where('company',$request['search'])
            ->paginate(10);

        return view('home',compact('machines'));
    }

    public function archive(){ // funkcja zwracająca widok z archiwum przeglądów

        $archives = DB::table('machines')
            ->join('archive','machines.id','=','id_machines')
            ->paginate(10);

        return view('archive',compact('archives'));
    }

    public function archive_search(Request $request){ // funkcja zwracająca widok z archiwum przeglądów

        $archives = DB::table('machines')
            ->join('archive','machines.id','=','id_machines')
            ->where('name',$request['search'])
            ->orWhere('company',$request['search'])
            ->paginate(10);

        return view('archive',compact('archives'));
    }

    public function delete($id){ // funkcja odpowiedzialna za usunięcie maszyny

        $query = DB::table('machines')
        ->where('id', $id)
        ->delete();

        $query2 = DB::table('users_machines')
        ->where('id_machines', $id)
        ->delete();

        if($query == true){
            Session::flash('success', 'Maszyna została usunięta'); 
        }
        else{
            Session::flash('error', 'Wystąpił błąd. Proszę spróbować poźniej'); 
        }
        return redirect()->back();
    }

    public function edit($id){ // funkcja wyswietlająca formularz edytowania maszyny z usupelnionymi polami
        $today = Carbon::today()->toDateString();
        $machine = DB::table('machines')
        ->where('id', $id)
        ->get();

        return view('edit',compact('machine','today'));

    }

    public function update(Request $request){ // funkcja odpowiedzialna za edytowanie danych wybranej maszyny

        $query = DB::table('machines')
                ->where('id', $request['id'])->limit(1)
                ->update(array(
                    'name' => $request['name'],
                    'model' => $request['model'],
                    'company' => $request['company'],
                    'overwiew_date' => $request['overwiew_date'],
                    'image' => $request['image'],
                    'description' => $request['description']
                ));

        if($query == true){
            Session::flash('success', 'Dane maszyny zostały zaktualizowane'); 
        }
        else{
            Session::flash('error', 'Wystąpił błąd. Proszę spróbować poźniej'); 
        }        

        return redirect('profile');

    }

}
