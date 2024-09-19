@extends('layouts.shelter')

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
                <th scope="col">Ime</th>
                <th scope="col">Prezime</th>
                <th scope="col">Mjesto</th>
                <th scope="col">Adresa</th>
                <th scope="col">Status udomljavanja</th>
                <th scope="col">Ime psa</th>
                <th scope="col">Uredi psa</th>
                <th scope="col">Detalji</th>
            </tr>
        </thead>
        <tbody>
            @foreach($answers as $answer)
                <tr>
                    <td>{{ $answer->user->name }}</td>
                    <td>{{ $answer->user->surname }}</td>
                    <td>{{ $answer->user->city }}</td> 
                    <td>{{ $answer->user->address }}</td> 
                    <td>{{ ucfirst($answer->status) }}</td><td>{{ $answer->dog->name }}</td> 
                    <td>
                        <a href="{{ route('shelter.dogs.editDog', $answer->dog->id) }}" class="btn btn-primary">Uredi</a>
                    </td>
                    <td>
                        <a href="{{ route('shelter.dogs.adoptionAnswersDetail', $answer->id) }}" class="btn btn-primary">Pogledaj detalje</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>

@endsection
