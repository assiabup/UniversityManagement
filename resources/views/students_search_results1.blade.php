<!-- resources/views/students/search_results.blade.php -->

@extends('contenue')

@section('title', 'Résultats de la recherche')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Résultats de la Recherche</h1>

        @if ($students->isEmpty())
            <div class="alert alert-warning text-center">
                Aucun résultat trouvé pour cette recherche.
            </div>
        @else
            <table class="table table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>CNE</th>
                        <th>Filière</th>
                        <th>Niveau</th>
                        <th>Action</th> <!-- Ajout de la colonne Action -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->cne }}</td>
                            <td>{{ $student->fieldOfStudy->name ?? 'Non spécifié' }}</td>
                            <td>{{ $student->level->name ?? 'Non spécifié' }}</td>
                            <td>
                                <form action="{{ route('students.destroy', $student->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 800px;
        }

        h1 {
            color: #343a40;
        }

        .table {
            margin-top: 20px;
        }

        .table thead th {
            background-color: #343a40;
            color: #fff;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        .alert-warning {
            background-color: #ffc107;
            color: #856404;
        }
    </style>
@endsection
