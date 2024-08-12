@extends('contenue')

@section('content')
<div class="container">
    <h2>Sélectionnez une Filière et un Niveau</h2>

    <form action="{{ route('teachers.showProfessors') }}" method="POST">
        @csrf

        <!-- Sélection des filières -->
        <div class="form-group">
            <label for="field_of_study">Filière</label>
            <select class="form-control" name="field_of_study" id="field_of_study">
                @foreach($fieldOfStudies as $field)
                    <option value="{{ $field->id }}">{{ $field->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Sélection des niveaux -->
        <div class="form-group">
            <label for="level">Niveau</label>
            <select class="form-control" name="level" id="level">
                @foreach($levels as $level)
                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Afficher les Professeurs</button>
    </form>
</div>
@endsection
