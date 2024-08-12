@extends('contenue')
@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-width: 100px;
            height: auto;
        }
        .view-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
            margin-right: 5px;
        }
    </style>

    <h1>Liste des Étudiants</h1>
    <p>Filière : {{ $fieldOfStudy->name }}</p>
    <p>Niveau : {{ $level->name }}</p>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>CNE</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->cne }}</td>
                    <td>
                        <a href="{{ route('students.details', $student->id) }}" class="view-button">Voir Détails</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection