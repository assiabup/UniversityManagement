@extends('contenue')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Choisir le Type d'Importation</h1>

    <div class="mt-4">
        <h3 class="mb-4">Sélectionnez le type d'importation :</h3>
        <ul class="list-unstyled">
            <li class="mb-3">
                <a href="{{ route('grades.import') }}" class="btn btn-primary w-100">Importation Session Normale</a>
            </li>
            <li>
                <a href="{{ route('import_rattrapage') }}" class="btn btn-warning w-100">Importation Session Rattrapage</a>
            </li>
        </ul>
    </div>
</div>
@endsection

@section('styles')
<style>
    body {
        background-color: #f8f9fa; /* Couleur de fond */
        font-family: Arial, sans-serif; /* Police par défaut */
    }

    .container {
        max-width: 600px; /* Largeur maximale du conteneur */
    }

    h1 {
        color: #343a40; /* Couleur du titre principal */
        text-align: center; /* Centrage du titre principal */
        margin-bottom: 40px; /* Marge en bas du titre principal */
    }

    h3 {
        color: #343a40; /* Couleur du titre secondaire */
        margin-bottom: 20px; /* Marge en bas du titre secondaire */
    }

    .btn-primary {
        background-color: #007bff; /* Couleur de fond du bouton principal */
        border-color: #007bff; /* Couleur de bordure du bouton principal */
    }

    .btn-primary:hover {
        background-color: #0056b3; /* Couleur de fond du bouton principal au survol */
        border-color: #0056b3; /* Couleur de bordure du bouton principal au survol */
    }

    .btn-warning {
        background-color: #ffc107; /* Couleur de fond du bouton de mise en garde */
        border-color: #ffc107; /* Couleur de bordure du bouton de mise en garde */
    }

    .btn-warning:hover {
        background-color: #e0a800; /* Couleur de fond du bouton de mise en garde au survol */
        border-color: #e0a800; /* Couleur de bordure du bouton de mise en garde au survol */
    }
</style>
@endsection