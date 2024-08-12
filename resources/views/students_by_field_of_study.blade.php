@extends('contenue')

@section('content')
    <h1>Étudiants de la filière : {{ $fieldOfStudy->name }}</h1>

    <table>
        <thead>
            <tr>
                <th>Nom de l'Étudiant</th>
                <th>Module</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                @foreach ($student->grades as $grade)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $grade->module->name }}</td>
                        <td>{{ $grade->score }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
@endsection