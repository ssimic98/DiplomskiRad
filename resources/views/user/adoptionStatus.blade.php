@extends('layouts.user')

@section('content')
<div class="container">
    <h1>Detalji Vašeg Zahtjeva</h1>

    <div class="card">
        <div class="card-header">
            Status Vašeg Zahtjeva
        </div>
        <div class="card-body">
            <h3>Odgovor: {{$adoptionAnswer->dog->user->name}} {{$adoptionAnswer->dog->user->surname}}</h3>
            @if ($adoptionAnswer->status == 'prihvaćen')
                <h5 class="card-title">Vaš zahtjev je prihvaćen!</h5>
                <p class="card-text">Čestitamo! Vaš zahtjev za psa "{{ $adoptionAnswer->dog->name }}" je prihvaćen.</p>
            @elseif ($adoptionAnswer->status == 'odbijen')
                <h5 class="card-title">Nažalost, Vaš zahtjev je odbijen.</h5>
                <p class="card-text">Nažalost, Vaš zahtjev za psa "{{ $adoptionAnswer->dog->name }}" je odbijen.</p>
            @else
                <h3 class="card-title">Vaš zahtjev je još uvijek u obradi.</h3>
                <p class="card-text">Vaš zahtjev za psa "{{ $adoptionAnswer->dog->name }}" još uvijek čeka na obradu.</p>
            @endif

            @if ($adoptionAnswer->dog->status == 'adopted')
                <p class="text-warning">Nažalost, pas "{{ $adoptionAnswer->dog->name }}" je u međuvremenu udomljen od strane nekog drugog.</p>
            @endif
            <a class="btn btn-primary" href="{{route('user.showDog',$adoptionAnswer->dog->id)}}">Prikaži psa</a>
        </div>
    </div>
</div>
@endsection
