<!-- resources/views/modules/create.blade.php -->
@extends('contenue')

@section('content')
    <div class="container">
        <h1>Ajouter un module pour le niveau {{ $level->name }}</h1>

        <form action="{{ route('modules.store', $level) }}" method="post">
            @csrf
            <div class="form-group">
                <label for="name">Nom du module :</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description :</label>
                <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Créer le module</button>
        </form>
    </div>
@endsection
