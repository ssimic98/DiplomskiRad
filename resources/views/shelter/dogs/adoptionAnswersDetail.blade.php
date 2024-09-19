@extends('layouts.shelter')

@section('content')
@if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif

<div class="container mt-4">
    <h1 class="mb-4">Detalji zahtjeva za udomljavanje</h1>

    <div class="card mb-4">
        <div class="card-header">
            <h2 class="card-title">Zahtjev od korisnika: {{ $answer->user->name }} {{ $answer->user->surname }}</h2>
            <h2 class="card-title">Email: {{ $answer->user->email }}
        </div>
        <div class="card-body">
            <h3 class="card-subtitle mb-3">Za psa: {{ $answer->dog->name }}</h3>
            <h4 class="mb-3">Odgovori:</h4>
            <ul class="list-group">
                @foreach($answer->adoption->questions as $question)
                    @if(array_key_exists($question->id, $answer->answers))
                        <li class="list-group-item">
                            <strong>{{ $question->question_text }}:</strong> 
                            {{ is_array($answer->answers[$question->id]) ? implode(', ', $answer->answers[$question->id]) : $answer->answers[$question->id] }}
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-4">
        <div class="row col-md-2"><form action ="{{route('shelter.dogs.adoptionAnswersAccept',$answer->id)}}" method="POST" >
            @csrf
            <button type="submit" class="btn btn-primary">Prihvati</button>
        </form></div>
        
        
        <form action="{{route('shelter.dogs.adoptionAnswersReject',$answer->id)}}" method="POSt">
            @csrf
            <button type="submit" class="btn btn-danger">Odbij</button>
        </form>
    </div>
</div>
@endsection
