@extends('contenue')

@section('content')
    <div class="container">
        <h1>Sélectionner Filière et Niveau pour Afficher les Résultats Finaux</h1>

        <form method="post" action="{{ route('display.final.results.show') }}">
            @csrf

            <div class="form-group">
                <label for="field_of_study">Choisir une Filière :</label>
                <select class="form-control" id="field_of_study" name="field_of_study_id">
                    @foreach($fieldOfStudies as $fieldOfStudy)
                        <option value="{{ $fieldOfStudy->id }}">{{ $fieldOfStudy->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="level">Choisir un Niveau :</label>
                <select class="form-control" id="level" name="level_id">
                    @foreach($levels as $level)
                        <option value="{{ $level->id }}">{{ $level->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Afficher les Résultats Finaux</button>
        </form>
    </div>
@endsection
