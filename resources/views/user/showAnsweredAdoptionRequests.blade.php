@extends('layouts.user')

@section('content')
@if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-2">
    <h1>Svi zahtjevi za udomljavanje</h1>
</div>
<div class="table-responsive">
    <table class="table  table-hover">
        <thead class="thead-light">
            <tr>
                <th scope="col">Pas</th>
                <th scope="col">Mjesto psa</th>
                <th scope="col">Azil</th>
                <th scope="col">Adresa azila</th>
                <th scope="col">Status udomljavanja</th>
                <th scope="col">Prikaži zahtjev</th>
                <th scope="col">Detalji</th>
            </tr>
        </thead>
        <tbody>
            @foreach($answers as $answer)
                <tr>
                    <td>{{ $answer->dog->name }}</td>
                    <td>{{ $answer->dog->location }}</td> 
                    <td>{{ $answer->dog->user->name }} {{ $answer->dog->user->surname }}</td> 
                    <td>{{ $answer->dog->user->address}}</td> 
                    <td>{{ ucfirst($answer->status) }}</td>
                    <td>
                        <a href="{{ route('user.adoptionStatus', $answer->id) }}" class="btn btn-primary">Prikaži detalje</a>
                    </td>
                    <td>
                        <a href="{{ route('user.showDog', $answer->dog->id) }}" class="btn btn-primary">Prikaži psa</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>

@endsection
