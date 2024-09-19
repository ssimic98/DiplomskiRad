@extends('layouts.shelter')
@section('content')
<div class="container d-flex justify-content-center formEdit mt-2">
    <div class="row col-md-7">
        <div class="text-center my-1">
            <img src="{{ asset('images/dog-paw.jpg') }}" alt="Paw" class="img-fluid" style="max-width: 100px;">
            <h1 class="">Dodaj novog psa</h1>
        </div>
        <form action="{{ route('shelter.dogs.storeDog') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row mb-1">
                <label for="poster" class="form-label">Slika psa</label>
                <input type="file" name="poster" id="poster" class="form-control @error('poster') is-invalid @enderror"
                    required>
                @error('poster')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>
            <div class="row mb-3">
                <label for="name" class="form-label">Ime</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="form-control @error('name') is-invalid @enderror" required>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>
            <div class="row mb-3">
                <label for="breed_id" class="form-label">Pasmina</label>
                <select name="breed_id" id="breed_id" class="form-select @error('breed_id') is-invalid @enderror"
                    required>
                    @foreach ($breeds as $breed)
                        <option value="{{ $breed->id }}">{{ $breed->breed }}</option>
                    @endforeach
                </select>
                @error('breed_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>
            <div class="row mb-3">
                <label for="location" class="form-label">Mjesto</label>
                <input type="text" name="location" id="location" value="{{ old('location') }}"
                    class="form-control @error('location') is-invalid @enderror" required>
                @error('location')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>
            <div class="row mb-3">
                <label for="birth_date" class="form-label">Datum rođenja</label>
                <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}"
                    class="form-control @error('birth_date') is-invalid @enderror" required>
                @error('birth_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>
            <div class="row mb-3">
                <label for="gender_id" class="form-label">Spol</label>
                <div id="gender_id">
                    @foreach ($genders as $gender)
                        <div class="form-check">
                            <input type="radio" name="gender_id" value="{{ $gender->id }}" id="gender{{ $gender->id }}"
                                class="form-check-input @error('gender_id') is-invalid @enderror" required>
                            <label for="gender{{ $gender->id }}" class="form-check-label">{{ $gender->gender }}</label>
                        </div>
                    @endforeach
                </div>
                @error('gender_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>
            <div class="row mb-3">
                <label for="characteristics" class="form-label">Karakteristike psa</label>
                <div id="characteristics" class="characteristic-container">
                    @foreach ($characteristics as $characteristic)
                        <div class="form-check characteristic-item">
                            <input type="checkbox" name="characteristics[]" value="{{ $characteristic->id }}"
                                id="characteristic{{ $characteristic->id }}"
                                class="form-check-input @error('characteristics') is-invalid @enderror">
                            <label for="characteristic{{ $characteristic->id }}"
                                class="form-check-label">{{ $characteristic->characteristic }}</label>
                        </div>
                    @endforeach

                    @error('characteristics')
                        <span class="invalid-feedback" style="display:inline;" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="health_statuses" class="form-label">Zdravstveni status</label>
                <div id="healthStatuses" class="health-status-container">
                    @foreach ($healthStatuses as $healthStatus)
                        <div class="form-check health-status-item" style="display: inline-block; margin-right: 10px;">
                            <input type="checkbox" name="health_statuses[]" value="{{ $healthStatus->id }}"
                                id="healthStatus{{ $healthStatus->id }}"
                                class="form-check-input @error('health_statuses') is-invalid @enderror">
                            <label for="healthStatus{{ $healthStatus->id }}"
                                class="form-check-label">{{ $healthStatus->status }}</label>
                        </div>
                    @endforeach

                    @error('health_statuses')
                        <span class="invalid-feedback" style="display: inline-block; margin-left: 10px;" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
            </div>
            <div class="row mb-3">
                <label for="description" class="form-label">Opis</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                    name="description" rows="3" required>{{ old('description') }}</textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mb-4 w-100">Dodaj psa</button>
        </form>
    </div>
</div>
@endsection