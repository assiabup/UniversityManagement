<!-- resour ces/views/select_field_of_study.blade.php -->
@extends('contenue')
@section('content') 
<h1>Sélectionner une filière</h1>

<form method="POST" action="{{ route('show.grades') }}">
    @csrf
    <label for="field_of_study_id">Filière :</label>
    <select name="field_of_study_id" id="field_of_study_id">
        @foreach ($fieldsOfStudy as $field)
            <option value="{{ $field->id }}">{{ $field->name }}</option>
        @endforeach
    </select>
    <button type="submit">Afficher les notes</button>
</form>
@endsection