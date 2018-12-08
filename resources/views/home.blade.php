@extends('layouts.app')
@section('content')
<title>MacMoto | Strona główna</title>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <center><br>
                    <form class="form-horizontal" method="GET" action="/search">
                        <div class="row">
                                {{ csrf_field() }}
                                <div class="col-4"></div>
                                <div class="col-4">
                                    <input type="text" name="search" class="form-control" required placeholder="Nazwa maszyny lub firmy"/> 
                                </div>
                                <div class="col-2">     
                                    <input type="submit" value="Wyszukaj" class="btn btn-primary float-left"/>
                                </div>
                        </div><br>
                    </form>
                </center><br>
            </div>
            <br>
            <div class="card">
                @forelse($machines as $machine)
                <div class="item">
                    <div class="left">
                        <img src="{{url('img')}}/{{$machine->image}}">
                    </div>
                    <div class="right">
                        <h2>{{$machine->name}} {{$machine->model}}</h2>
                        <hr>
                        <h5>Data następnego przeglądu: {{ date('d.m.Y', strtotime($machine->overwiew_date)) }}</h5><br>
                        <p>{{$machine->description}}</p>
                        <a href="{{url('item')}}/{{$machine->id}}"><button class="btn btn-primary">Więcej informacji</button></a>
                    </div>
                </div>
                @empty
                    <center class="padding"><h2>Brak maszyn spełniających wymagania.</h2><center>
                @endforelse
            </div><br>
            {{$machines->links()}} 
        </div>
    </div>
</div>
@endsection
