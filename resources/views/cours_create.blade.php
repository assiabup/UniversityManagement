@extends('contenue')

@section('content')
    <div class="container">
        <h1>Ajouter un Cours au Module : {{ $module->name }}</h1>

        <form action="{{ route('cours.store', ['moduleId' => $module->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="title">Titre du Cours :</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="type">Type de cours :</label>
                <input type="text" id="type" name="type" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="pdf_file">PDF du Cours :</label>
                <input type="file" id="pdf_file" name="pdf_file" class="form-control-file" accept="application/pdf" required>
            </div>

            @if ($module->fieldOfStudy)
    <input type="hidden" name="field_of_study_id" value="{{ $module->fieldOfStudy->id }}">
@endif

@if ($module->level)
    <input type="hidden" name="level_id" value="{{ $module->level->id }}">
@endif


            <button type="submit" class="btn btn-primary">Ajouter le Cours</button>
        </form>
    </div>
@endsection