@extends('layouts.user')

@section('content')
<div class="container d-flex justify-content-center align-items-center formEdit mt-2">
    <div class="row col-md-7">
        <div class="text-center my-1">
            <img src="{{ asset('images/dog-paw.jpg') }}" alt="Paw" class="img-fluid" style="max-width: 100px;">
            <h1>Obrazac za udomljavanje za: {{ $dog->name }}</h1>
        </div>
        <form action="{{ route('user.submitAdoptionForm', $dog->id) }}" method="POST">
            @csrf
            <input type="hidden" name="adoption_id" value="{{ $adoption->id }}">
            <input type="hidden" name="dog_id" value="{{ $dog->id }}">
            @foreach($questions as $question)
                <div class="row mb-3">
                    <label class="form-label">{{ $question->question_text }}</label>
                    @if($question->question_type == 'text')
                        <input type="text" name="answers[{{ $question->id }}]"
                            class="form-control {{ $errors->has('answers.' . $question->id) ? 'is-invalid' : '' }}">
                        @error('answers.' . $question->id)
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        @elseif($question->question_type == 'radio')
                    <div class="radio-container">
                    
                      @foreach($question->options as $option)
                            <div class="form-check radio-item">
                                <input class="form-check-input {{ $errors->has('answers.' . $question->id) ? 'is-invalid' : '' }}"
                                    type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}">
                                <label class="form-check-label">{{ $option }}</label>
                            </div>
                        @endforeach
                        @error('answers.' . $question->id)
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                      
                    @elseif($question->question_type == 'checkbox')
                        <div class="checkbox-container">
                            @foreach($question->options as $option)
                                <div class="form-check checkbox-item">
                                    <input
                                        class="form-check-input {{ $errors->has('answers.' . $question->id) ? 'is-invalid' : '' }}"
                                        type="checkbox" name="answers[{{ $question->id }}][]" value="{{ $option }}">
                                    <label class="form-check-label">{{ $option }}</label>
                                </div>

                                @error('answers.' . $question->id)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
            <button type="submit" class="btn btn-primary w-100 mb-4">Pošalji obrazac</button>
        </form>
    </div>
</div>
@endsection