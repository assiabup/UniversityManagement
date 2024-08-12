@extends('contenue')

@section('content')
    <h1>Rechercher un étudiant par CNE</h1>

    <form action="{{ route('students.search') }}" method="GET">
        <div class="form-group">
            <label for="cne">CNE de l'étudiant :</label>
            <input type="text" class="form-control" id="cne" name="cne" placeholder="Entrez le CNE de l'étudiant">
        </div>
        <button type="submit" class="btn btn-primary">Rechercher</button>
    </form>
@endsection
