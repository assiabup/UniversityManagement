@extends('contenue')
@section('content')





<h1>Étudiants de la filière {{ $fieldOfStudy->name }}</h1>

@foreach ($students as $student)
    <h2>{{ $student->name }}</h2>
    <ul>
        @foreach ($student->grades as $grade)
            <li>Module: {{ $grade->module->name }}, Note: {{ $grade->score }}, Statut: {{ $grade->is_pass ? 'Validé' : 'Rattrapage' }}</li>
        @endforeach
    </ul>
@endforeach
@endsection