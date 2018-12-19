@extends('layouts.app')
@section('content')
<title>Rafaez Company | Archiwum</title>
<div class="container">
    <div class="card">
        <center><br>
            <form class="form-horizontal" method="GET" action="/archive_search">
                <div class="row">
                        {{ csrf_field() }}
                        <div class="col-4"></div>
                        <div class="col-4">
                            <input type="text" name="search" class="form-control" required placeholder="Nazwa maszyny lub firmy"/> 
                        </div>
                        <div class="col-2">     
                            <input type="submit" value="Wyszukaj" class="btn btn-primary float-left"/>
                        </div>
                            <a href="{{url('archive')}}" class="float-left btn btn-danger"/>Wyczyść</a>
                </div><br>
            </form>
        </center><br>
    </div>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">  
                <div class="perfect"><br><br>
                    <div class="card">
                      <div class="card-header">
                        Archiwum wykonanych przeglądów
                      </div>
                      <div class="card-body">
                        @if(count($archives)>0)
                        <table class="table table-hover table-bordered">
                          <thead>
                            <tr>
                              <th scope="col">Id</th>
                              <th scope="col">Nazwa i model</th>
                              <th scope="col">Firma</th>
                              <th scope="col">Stan techniczny</th>
                              <th scope="col">Przegląd wykonał</th>
                              <th scope="col">Data nast. przeglądu</th>
                              <th scope="col">Data odbycia przeglądu</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($archives as $archive)
                            <tr>
                              <th rowspan="2" scope="row" class="top"><br>{{$archive->id}}</th>
                              <td class="top"><a href="{{url('item')}}/{{$archive->id_machines}}">{{$archive->name}} | {{$archive->model}}</a></td>
                              <td class="top">{{$archive->company}}</td>
                              <td class="top">
                                @if($archive->status=="Sprawna")
                                    <span style="color: green;">{{$archive->status}}</span>
                                @endif
                                @if($archive->status=="W naprawie")
                                    <span style="color: orange;">{{$archive->status}}</span>
                                @endif
                                @if($archive->status=="Uszkodzona")
                                    <span style="color: red;">{{$archive->status}}</span>
                                @endif 
                              </td>
                              <td class="top">{{$archive->status_user}}</td>
                              <td class="top">{{date('d.m.Y', strtotime($archive->overwiew_date))}}</td>
                              <td class="top">{{date('d.m.Y | H:m:s', strtotime($archive->created_at))}}</td>
                              </tr>
                              <tr >
                              <td colspan="7"><b>Opis przeglądu:</b> {{$archive->status_desc}}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                        @else
                        <center class="padding"><h2>Brak przeprowadzonych przeglądów</h2><center>
                        @endif
                        <center class="padding">{{ $archives->links() }}<center>
                      </div> 
                    </div>  
                </div>  
            </div>
        </div>
    </div>
</div>
@endsection
