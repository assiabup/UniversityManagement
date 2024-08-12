@extends('contenue')

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4">Devoirs soumis</h2>
    <div class="table-responsive">
        <table class="table table-striped custom-table">
            <thead>
                <tr>
                    <th scope="col">Nom de l'Étudiant</th>
                    <th scope="col">CNE</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($submissions as $submission)
                    <tr>
                        <td>{{ $submission->student->name }}</td>
                        <td>{{ $submission->student->cne }}</td>
                        <td>{{ $submission->student->email }}</td>
                        <td>
                            <a href="{{ route('professor.download', ['homeworkId' => $submission->id]) }}" class="btn btn-primary" target="_blank" rel="noopener noreferrer">
                                Télécharger
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Aucun devoir soumis pour ce module.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    .custom-table {
        background-color: #fff; /* Couleur de fond de la table */
        border-radius: 10px; /* Bord arrondi */
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Ombre */
    }

    .custom-table th,
    .custom-table td {
        border: none; /* Suppression de la bordure */
    }

    .btn-primary {
        background-color: #007bff; /* Couleur de fond du bouton */
        border-color: #007bff; /* Couleur de la bordure du bouton */
    }

    .btn-primary:hover {
        background-color: #0056b3; /* Couleur de fond au survol */
        border-color: #0056b3; /* Couleur de la bordure au survol */
    }

    .btn-primary:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5); /* Effet de focus */
    }
</style>
@endsection