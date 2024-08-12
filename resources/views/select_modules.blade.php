@extends('contenue')

@section('content')
<div class="container">
    <h2>Sélection des modules</h2>

    <form action="{{ route('teachers.store') }}" method="POST">
        @csrf

        <!-- Afficher les modules -->
        @foreach($modules as $module)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="modules[]" value="{{ $module->id }}">
                <label class="form-check-label">{{ $module->name }}</label>
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Créer Professeur</button>
    </form>
</div>
@endsection
