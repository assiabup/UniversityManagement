@extends('contenue')

@section('content')
    <div class="container">
        <h1 class="mb-4">Notes des Étudiants</h1>

        <p class="text-muted">Filière : {{ $selectedFiliere->name }}</p>
        <p class="text-muted">Niveau : {{ $selectedNiveau->name }}</p>

        @if($etudiants->isEmpty())
            <div class="alert alert-info" role="alert">
                Aucune note disponible pour cette filière et ce niveau.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Étudiant</th>
                            <th scope="col">Module</th>
                            <th scope="col">Note</th>
                            <th scope="col">Validation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($etudiants as $etudiant)
                            @foreach($etudiant->grades as $grade)
                                <tr>
                                    <td>{{ $etudiant->name }}</td>
                                    <td>{{ $grade->module->name }}</td>
                                    <td>{{ number_format($grade->score, 2) }}</td>
                                    <td>
                                        @if($grade->is_pass)
                                            <span class="text-success">Validé</span>
                                        @else
                                            <span class="text-danger">Rattrapage nécessaire</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

@section('styles')
<style>
    body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
    }

    h1 {
        color: #343a40;
    }

    .text-muted {
        color: #6c757d;
    }

    .alert {
        margin-top: 20px;
    }

    .table {
        margin-top: 20px;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .table th {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 123, 255, 0.05);
    }

    .table-striped tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.1);
    }

    .text-success {
        color: #28a745;
    }

    .text-danger {
        color: #dc3545;
    }
</style>
@endsection