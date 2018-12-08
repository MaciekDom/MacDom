@extends('layouts.app')
@section('content')
<title>MacMoto | Użytkownicy maszyny</title>
@foreach($machine as $data)
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
        <div class="col-md-6"><br>
            <div class="card">
              <div class="card-header"><center>Przypisz użytkownika do maszyny {{ $data->name }}</center></div>
                <div class="card-body">
                  <form class="form-horizontal" method="POST" action="/assign_user">
                    {{ csrf_field() }}<br>
                    <div class="col-md-2 float-left"></div>
                    <div class="col-md-8 float-left">
                      <div class="row-4">
                        <input type="text" value="{{$data->id}}" name="machine_id" hidden>
                        <select class="form-control" name="user_id" required>
                          <option selected disabled>Wybierz</option>
                          @foreach($free_users as $user)
                            <option value="{{$user->id}}">{{$user->login}} | {{$user->name}}</option>
                          @endforeach
                        </select>
                        <br>
                        <center><input type="submit" class="btn btn-primary" style="width: 150px;" value="Przypisz"></center>
                      </div>
                    </div>
                  </form>  
                </div>
            </div>
        </div>  

        <div class="col-md-8"><br>
            <div class="card">
                <div class="card-header"><center>Lista użytkowników maszyny {{ $data->name }}</center></div>
                <div class="card-body">
                  @if(count($assigned_users) > 0)
                  <table class="table table-hover table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Imię i nazwisko</th>
                        <th scope="col">Login</th>
                        <th scope="col" style="width: 60px;">Opcje</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($assigned_users as $users)
                      <tr>
                        <th scope="row" class="top">{{$users->id}}</th>
                        <td class="top">{{$users->name}}</td>
                        <td class="top">{{$users->login}}</td>
                        <td>
                          <form class="form-horizontal" method="POST" action="/separate_user">
                            {{ csrf_field() }}
                            <input type="text" hidden name="user_id" value="{{$users->id}}">
                            <input type="text" hidden name="machine_id" value="{{$data->id}}">
                            <button class="btn btn-danger" onclick="return confirm('Jesteś pewny? Operacji tej nie będzie można cofnąć!')"><i class="fas fa-times"></i></button>
                          </form>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  @else
                  <center class="padding"><h3>Brak przypisanych użytkowników</h3><center>
                  @endif
                </div>
            </div>
        </div>
    </div>
@endforeach  
</div>
@endsection
