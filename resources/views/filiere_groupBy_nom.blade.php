<!-- resources/views/field_of_studies/index.blade.php -->

<@extends('contenue')
@section('content')
    <h1>Liste des Filières</h1>

    <table>
        <thead>
            <tr>
                <th>Nom de la Filière</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($groupedFieldOfStudies as $groupName => $fieldOfStudies)
                <tr>
                    <td><strong>{{ $groupName }}</strong></td>
                </tr>
                @foreach ($fieldOfStudies as $fieldOfStudy)
                    <tr>
                        <td>{{ $fieldOfStudy->name }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
@endsection
