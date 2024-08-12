<!-- resources/views/students/search_by_name.blade.php -->

@extends('contenue')

@section('content')
    <h1>Rechercher un étudiant par Nom</h1>

    <form action="{{ route('students.search') }}" method="GET">
        <div class="form-group">
            <label for="name">Nom de l'étudiant :</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Entrez le nom de l'étudiant">
        </div>
        <button type="submit" class="btn btn-primary">Rechercher</button>
    </form>
@endsection
