@extends('contenue')

@section('content')
    <div class="container">
        <h1>Sélectionnez les critères</h1>
        <form method="POST" action="{{ route('get-absences-list') }}">
            @csrf
            <div class="form-group">
                <label for="filiere">Filière:</label>
                <select class="form-control" id="filiere" name="field_of_study">
                    @foreach($filieres as $filiere)
                        <option value="{{ $filiere->id }}">{{ $filiere->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="niveau">Niveau:</label>
                <select class="form-control" id="niveau" name="level">
                    @foreach($niveaux as $niveau)
                        <option value="{{ $niveau->id }}">{{ $niveau->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="module">Module:</label>
                <select class="form-control" id="module" name="module">
                    @foreach($modules as $module)
                        <option value="{{ $module->id }}">{{ $module->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Voir les absences</button>
        </form>
    </div>
@endsection
