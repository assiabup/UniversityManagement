@extends('contenue')

@section('content')


@foreach($students as $student)
    <div>
        <h2>{{ $student->name }}</h2>
        <ul>
            @foreach($student->grades as $grade)
                <li>
                    Module: {{ $grade->module->name }}<br>
                    Note: {{ $grade->score}}<br>
                    Statut: {{ $grade->is_pass ? 'Validé' : 'Rattrapage' }}
                </li>
            @endforeach
        </ul>
    </div>
@endforeach
@endsection