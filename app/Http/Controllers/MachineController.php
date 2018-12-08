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
