@extends('layouts.app')
@section('content')
<title>MacMoto | Edycja maszyny</title>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6"><br>
            <div class="card">
              @foreach($machine as $data)
                <div class="card-header"><center>Edycja maszyny o nazwie {{ $data->name }}</center></div>
                <div class="card-body">
                      <form class="form-horizontal" method="POST" action="/update">
                          {{ csrf_field() }}
                        <div class="col-12 justify-content-center">
                          <label>Nazwa</label>
                          <input type="text" value="{{ $data->id }}" name="id" hidden>
                          <input type="text" class="form-control bottom" value="{{ $data->name }}" name="name" required>
                          <label>Model</label>
                          <input type="text" class="form-control bottom" value="{{ $data->model }}" name="model" required>
                          <label>Firma</label>
                          <input type="text" class="form-control bottom" value="{{ $data->company }}" name="company" required>
                          <label>Data następnego przeglądu</label>
                          <input type="date" class="form-control bottom" value="{{ $data->overwiew_date }}" min="{{$today}}" name="overwiew_date" required>
                          <label>Zdjęcie</label>
                          <input type="file" class="form-control bottom" value="{{ $data->image }}" name="image" required>
                          <label>Opis</label>
                          <textarea class="form-control float-left bottom" name="description" required>{{ $data->description }}</textarea>
                          <input type="submit" class="btn btn-primary btn-block btn-lg" value="Zatwierdź">
                        </div>
                      </form> 
                    <br>
                </div>
              @endforeach  
            </div>
        </div>
    </div>
</div>
@endsection
