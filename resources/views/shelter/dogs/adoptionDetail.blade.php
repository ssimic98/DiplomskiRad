@extends('layouts.shelter')

@section('content')
<div class="container">
    <h1>Detalji Obrasca</h1>

    <div class="card">
        <div class="card-header">
            {{ $adoption->title }}
        </div>
        <div class="card-body">
            <h5 class="card-title">Opis</h5>
            <p class="card-text">{{ $adoption->description }}</p>

            <h5 class="card-title">Pitanja</h5>
            <ul class="list-group">
                @foreach ($adoption->questions as $question)
                    <li class="list-group-item">
                        <strong>{{ $question->question_text }}</strong>
                        @if ($question->question_type !== 'text')
                            <ul>
                                @foreach (json_decode($question->options, true) as $option)
                                    <li>{{ $option }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>

            <a href="{{ route('shelter.dogs.showDogs') }}" class="btn btn-primary mt-3">Povratak na popis</a>
        </div>
    </div>
</div>
@endsection
