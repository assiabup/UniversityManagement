@extends('contenue')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Résultats des Étudiants</h1>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Étudiant</th>
                        <th scope="col">Score</th>
                        <th scope="col">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td>{{ $student['name'] }}</td>
                            <td>{{ $student['score'] }}</td>
                            <td>
                                <span class="badge 
                                    @if ($student['status'] == 'Validé')
                                        badge-success
                                    @elseif ($student['status'] == 'Note Eliminatoire')
                                        badge-danger
                                    @elseif ($student['status'] == 'Non validé')
                                        badge-warning
                                    @else
                                        badge-secondary
                                    @endif
                                ">
                                    {{ $student['status'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Aucun résultat trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        h1 {
            color: #007bff;
        }

        .table {
            margin-top: 20px;
        }

        .badge {
            font-size: 1rem;
            padding: 0.5em 0.75em;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-danger {
            background-color: #dc3545;
        }

        .badge-warning {
            background-color: #ffc107;
        }

        .badge-secondary {
            background-color: #6c757d;
        }
    </style>
@endsection