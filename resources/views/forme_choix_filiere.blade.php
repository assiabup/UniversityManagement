@extends('contenue')

@section('content')
<form action="{{ route('field_of_study.modules', ['id' => $selectedFieldOfStudyId]) }}" method="get">
    <label for="field_of_study_id">Choisir une filière :</label>
    <select name="field_of_study_id" id="field_of_study_id">
        @foreach($fieldOfStudies as $filiere)
            <option value="{{ $filiere->id }}">{{ $filiere->name }}</option>
        @endforeach
    </select>
    <button type="submit">Afficher les modules</button>
</form>

@endsection
