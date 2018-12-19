@extends('layouts.app')
@section('content')
<title>MacMoto | Profil</title>
<div id="modal-machine" class="modal fade">
  <div class="modal-dialog modal-box  col-8">
    <div class="modal-content">
      <div class="modal-header">
       <center class="col justify-content-center">Dodawanie nowej maszyny</center> 
       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body justify-content-center">
        <form class="form-horizontal" method="POST" action="/add_machine">
            {{ csrf_field() }}
          <div class="col-12 justify-content-center">
            <label>Nazwa</label>
            <input type="text" class="form-control bottom" name="name" required>
            <label>Model</label>
            <input type="text" class="form-control bottom" name="model" required>
            <label>Firma</label>
            <input type="text" class="form-control bottom" name="company" required>
            <label>Data następnego przeglądu</label>
            <input type="date" class="form-control bottom" min="{{$today}}" name="date" required>
            <label>Zdjęcie</label>
            <input type="file" class="form-control bottom" name="image" required>
            <label>Opis</label>
            <textarea class="form-control float-left bottom" name="description" required></textarea>
            <input type="submit" class="btn btn-primary btn-block btn-lg" value="Zatwierdź">
          </div>
        </form>              
      </div>
    </div>
  </div>
</div>  
<div id="modal-change_pass" class="modal fade">
  <div class="modal-dialog modal-box">
    <div class="modal-content">
      <div class="modal-header">    
      <center class="col justify-content-center">Zmiana hasła</center> 
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>    
      </div>
      <div class="modal-body">
        <center>
         <form class="form-horizontal" method="POST" action="/change_pass">
            {{ csrf_field() }}
          <div class="form-group">
                <input type="password" style="width: 250px;" name="pass" placeholder="Nowe hasło" class="form-control" required/>
          </div>          
          <div class="form-group">
                <input type="password" style="width: 250px;" name="pass-conf" placeholder="Powtórz nowe hasło" class="form-control" required/>
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Zmień hasło">
          </div>
        </form> 
        </center>       
      </div>
    </div>
  </div>
</div>
<div class="container">
    @if (\Session::has('success'))
        <div class="alert alert-success">
            <h5><center>{!! \Session::get('success') !!}</center></h5>   
        </div>
    @endif 
    @if (\Session::has('error'))
        <div class="alert alert-danger">
            <h5><center>{!! \Session::get('error') !!}</center></h5>          
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="row">
                    <div class="col-6">
                        <h2 class="padding">Jesteś zalogowany jako {{Auth::user()->name}}</h2>
                    </div>
                    <div class="col-6">
                        @if(Auth::user()->login!="admin")
                          <a onclick="return confirm('Jesteś pewny? Operacji tej nie będzie można cofnąć!')" href="{{ url('destroy') }}"><button class="btn btn-danger padding float-right">Usuń konto</button></a>
                        @else
                          <button class="btn btn-success padding" data-toggle="modal" data-target="#modal-machine">Dodaj maszynę</button>  
                          <a href="{{url('archive')}}"><button class="btn btn-secondary padding">Archiwum przeglądów</button></a>
                        @endif  
                        <button class="btn btn-primary padding float-right" data-toggle="modal" data-target="#modal-change_pass">Zmień hasło</button>
                    </div>
                </div> 





                @if(Auth::user()->login=="admin")
                    <div class="perfect">
                        <div class="card">
                          <div class="card-header">
                            Lista maszyn w systemie
                          </div>
                          <div class="card-body">
                            @if(count($machines)>0)
                            <table class="table table-hover table-bordered">
                              <thead>
                                <tr>
                                  <th scope="col">Id</th>
                                  <th scope="col">Nazwa i model</th>
                                  <th scope="col">Firma</th>
                                  <th scope="col">Stan techniczny</th>
                                  <th scope="col">Przegląd wykonał</th>
                                  <th scope="col">Data nast. przeglądu</th>
                                  <th scope="col">Opcje</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($machines as $machine)
                                <tr>
                                  <th scope="row" class="top">{{$machine->id}}</th>
                                  <td class="top"><a href="{{url('item')}}/{{$machine->id}}">{{$machine->name}} {{$machine->model}}</a></td>
                                  <td class="top">{{$machine->company}}</td>
                                  <td class="top">
                                    @if($machine->status=="Sprawna")
                                        <span style="color: green;">{{$machine->status}}</span>
                                    @endif
                                    @if($machine->status=="W naprawie")
                                        <span style="color: orange;">{{$machine->status}}</span>
                                    @endif
                                    @if($machine->status=="Uszkodzona")
                                        <span style="color: red;">{{$machine->status}}</span>
                                    @endif 
                                  </td>
                                  <td class="top">{{$machine->status_user}}</td>
                                  <td class="top">{{date('d.m.Y', strtotime($machine->overwiew_date))}}</td>
                                  <td>
                                    <a href="{{ url('machine_users/'.$machine->id) }} "><button class="btn btn-primary"><i class="fas fa-user-friends"></i></button></a>
                                    <a href="{{ url('edit/'.$machine->id) }}"><button class="btn btn-warning"><i class="fas fa-pencil-alt"></i></button></a>
                                    <a onclick="return confirm('Jesteś pewny? Operacji tej nie będzie można cofnąć!')" href="{{ url('delete_machine/'.$machine->id) }}"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>
                                  </td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                            @else
                            <center class="padding"><h2>Brak maszyn w systemie</h2><center>
                            @endif
                          </div> 
                        </div>  
                    </div>  
                    <div class="perfect">
                        <div class="card">
                          <div class="card-header">
                            Lista użytkowników systemu
                          </div>
                          <div class="card-body">
                            @if(count($users) > 0)
                            <table class="table table-hover table-bordered">
                              <thead>
                                <tr>
                                  <th scope="col">Id</th>
                                  <th scope="col">Imię i nazwisko</th>
                                  <th scope="col">Login</th>
                                  <th scope="col">Data i godzina rejestracji</th>
                                  <th scope="col">Opcje</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($users as $user)
                                <tr>
                                  <th scope="row" class="top">{{$user->id}}</th>
                                  <td class="top">{{$user->name}}</td>
                                  <td class="top">{{$user->login}}</td>
                                  <td class="top">{{date('d.m.Y H:m:s', strtotime($user->created_at))}}</td>
                                  <td><a onclick="return confirm('Jesteś pewny? Operacji tej nie będzie można cofnąć!')" href="{{ url('delete_user/'.$user->id) }}"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a></td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                            @else
                            <center class="padding"><h2>Brak użytkowników w systemie</h2><center>
                            @endif
                          </div> 
                        </div>  
                    </div>
                @else    
                    <div class="perfect">
                      <div class="card">
                        <div class="card-header">
                          Lista dostępnych maszyn
                        </div>
                        <div class="card-body">
                          @if(count($machines) > 0)
                          <table class="table table-hover table-bordered">
                            <thead>
                              <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Nazwa i model</th>
                                <th scope="col">Firma</th>
                                <th scope="col">Stan techniczny</th>
                                <th scope="col">Przegląd wykonał</th>
                                <th scope="col">Data nast. przeglądu</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($machines as $machine)
                              <tr>
                                <th scope="row">{{$machine->id}}</th>
                                <td><a href="{{url('item')}}/{{$machine->id}}">{{$machine->name}} {{$machine->model}}</a></td>
                                <td>{{$machine->company}}</td>
                                <td>
                                  @if($machine->status=="Sprawna")
                                      <span style="color: green;">{{$machine->status}}</span>
                                  @endif
                                  @if($machine->status=="W naprawie")
                                      <span style="color: orange;">{{$machine->status}}</span>
                                  @endif
                                  @if($machine->status=="Uszkodzona")
                                      <span style="color: red;">{{$machine->status}}</span>
                                  @endif 
                                </td>
                                <td>{{$machine->status_user}}</td>
                                <td>{{date('d.m.Y', strtotime($machine->overwiew_date))}}</td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                          @else
                          <center class="padding"><h2>Brak maszyn, do których jesteś przypisany</h2><center>
                          @endif
                        </div> 
                      </div>  
                    </div> 
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
