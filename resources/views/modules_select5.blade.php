@extends('contenue')

@section('content')
<div class="container-fluid d-flex justify-content-center align-items-center vh-100" style="background-color: #f8f9fa;">
    <div class="card p-4" style="width: 400px;">
        <h2 class="text-center mb-4">Sélectionnez une filière et un niveau</h2>
        <form method="POST" action="{{ route('modules.show') }}">
            @csrf
            <div class="form-group">
                <label for="field_of_study" class="text-dark">Filière :</label>
                <select class="form-control" id="field_of_study" name="field_of_study_id">
                    @foreach ($fieldsOfStudy as $field)
                    <option value="{{ $field->id }}">{{ $field->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="level" class="text-dark">Niveau :</label>
                <select class="form-control" id="level" name="level_id">
                    @foreach ($levels as $level)
                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block mt-4">Afficher les modules</button>
        </form>
    </div>
</div>

<style>
    .card {
        background-color: #fff; /* Couleur de fond de la carte */
        border-radius: 10px; /* Coins arrondis */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Ombre */
    }

    .form-group label {
        color: #333; /* Couleur du texte des labels */
    }

    .form-control {
        border: 1px solid #ced4da; /* Bordure */
    }

    .btn-primary {
        background-color: #007bff; /* Couleur de fond du bouton */
        border-color: #007bff; /* Couleur de la bordure du bouton */
    }

    .btn-primary:hover {
        background-color: #0056b3; /* Couleur de fond au survol */
        border-color: #0056b3; /* Couleur de la bordure au survol */
    }
</style>

@endsection