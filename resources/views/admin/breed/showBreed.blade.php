@extends('layouts.admin')
@section('content')
<div class="container mt-1">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h2">Pasmine</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBreedModal">
            Dodaj
        </button>
        
        <div class="modal fade" id="addBreedModal" tabindex="-1" aria-labelledby="addBreedModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBreedModalLabel">Dodaj novu pasminu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.breed.storeBreed') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="breed" class="form-label">Pasmina</label>
                                <input type="text" name="breed" id="breed"  value="{{ old('breed') }}" class="form-control @error('breed') is-invalid @enderror" placeholder="Unesite naziv pasmine" required>
                                
                                @error('breed')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Dodaj</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Pasmina</th>
                    <th>Akcija</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($breeds as $breed)
                    <tr>
                        <td>{{ $breed->id }}</td>
                        <td>{{ $breed->breed }}</td>
                        <td>
                            
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editBreedModal{{ $breed->id }}">
                                Uredi
                            </button>

                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $breed->id }}">
                                Obriši
                            </button>

                            <div class="modal fade" id="editBreedModal{{ $breed->id }}" tabindex="-1" aria-labelledby="editBreedModalLabel{{ $breed->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editBreedModalLabel{{ $breed->id }}">Ažuriraj</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.breed.updateBreed', $breed->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="breed" class="form-label">Pasmina</label>
                                                    <input type="text" name="breed" id="breed" value="{{ $breed->breed }}"class="form-control @error('breed') is-invalid @enderror" required>
                                                    
                                                    @error('breed')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <button type="submit" class="btn btn-primary">Spremi</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="deleteModal{{ $breed->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $breed->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $breed->id }}">Potvrda brisanja</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Jeste li sigurani da želite obrisati ovu pasminu?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Otkaži</button>
                                            <form action="{{ route('admin.breed.deleteBreed', $breed->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Obriši</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@if ($errors->has('breed'))
<script>
    window.onload=function()
    {
        var breedModal=new bootstrap.Modal(document.getElementById('addBreedModal'));
        breedModal.show();
    }
</script>
@endif
@endsection
