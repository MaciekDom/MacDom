@extends('layouts.app')
@section('content') 
@foreach($item as $machine) 
<div id="modal-change_status" class="modal fade">
  <div class="modal-dialog modal-box">
    <div class="modal-content">
      <div class="modal-header">    
      <center class="col justify-content-center">Formularz przeglądu technicznego</center> 
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>    
      </div>
      <div class="modal-body">
        <div class="modal-body justify-content-center">
        <form class="form-horizontal" method="POST" action="/change_status">
            {{ csrf_field() }}
          <div class="col-12 justify-content-center">
            <label>Stan techniczny</label>
            <select name="status" class="form-control bottom">
              <option selected disabled>Wybierz</option>
              <option value="Sprawna">Sprawna</option>
              <option value="W naprawie">W naprawie</option>
              <option value="Uszkodzona">Uszkodzona</option>
            </select>
            <label>Data następnego przeglądu</label>
            <input type="date" class="form-control bottom" min="{{$today}}" name="date" required>
            <label>Opis przeglądu</label>
            <textarea class="form-control float-left bottom" name="description" required></textarea>
            <input type="text" hidden value="{{$machine->id}}" name="id"/>
            <input type="submit" class="btn btn-primary btn-block btn-lg" value="Zatwierdź">
          </div>
        </form>              
      </div>      
      </div>
    </div>
  </div>
</div>
<title>MacMoto | {{$machine->name}} {{$machine->model}}</title>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="row">
                    <div class="col padding">
                        <h2>{{$machine->name}} {{$machine->model}} 
                        <button class="btn btn-success float-right" data-toggle="modal" data-target="#modal-change_status">Wykonaj przegląd</button>
                        <hr></h2>
                        <h4>Firma: {{$machine->company}}</h4>  
                        <h4>Stan techniczny: 
                          @if($machine->status=="Sprawna")
                          <span style="color: green;">{{$machine->status}}</span>
                          @endif
                          @if($machine->status=="W naprawie")
                          <span style="color: orange;">{{$machine->status}}</span>
                          @endif
                          @if($machine->status=="Uszkodzona")
                          <span style="color: red;">{{$machine->status}}</span>
                          @endif  
                        </h4> 
                        <h4>Opis maszyny:</h4>
                        <p>{{$machine->description}}</p>                
                    </div>
                    <div class="col padding">
                      <img src="{{url('img')}}/{{$machine->image}}">
                    </div>
                </div>
                <div class="row">
                  <div class="col padding">
                    <h4>Opis ostatniego przeglądu:</h4>
                    <p>{{$machine->status_desc}}</p>
                    <h4>Osoba wystawiająca: {{$machine->status_user}}</h4> 
                    <h4>Data następnego przeglądu: {{date('d.m.Y', strtotime($machine->overwiew_date))}}</h4>
                  </div>
                  @if(!$users->isEmpty())
                  <div class="col padding">
                    <h4>Przypisani użytkownicy:</h4>
                    <ul>
                      @foreach($users as $user)
                      <li>{{$user->name}}</li>
                      @endforeach
                    </ul>
                  </div>
                  @endif
                </div>    
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
