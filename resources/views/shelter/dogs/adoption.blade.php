@extends('layouts.shelter')

@section('content')
@if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif

<div class="container mt-1">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h2">Obrasci</h1>
    </div>
    @if($adoptions->count() > 0)
    <div class="table-responsive">
        <table class="table  table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Naslov</th>
                    <th>Opis</th>
                    <th>Akcije</th>
                </tr>
            </thead>
            <tbody>
                @foreach($adoptions as $adoption)
                    <tr>
                        <td>{{ $adoption->title }}</td>
                        <td>{{ $adoption->description }}</td>
                        <td>
                            <a href="{{ route('shelter.dogs.adoptionDetail', $adoption->id) }}" class="btn btn-primary">Pogledaj</a>
                            <form action="{{ route('shelter.dogs.deleteAdoption', $adoption->id) }}" method="POST" onsubmit="return confirm('Jeste li sigurni da želite obrisati ovaj obrazac?');" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Obriši</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Trenutno nemate nijedan obrazac.</p>
    @endif
    </div>
</div>
@endsection
