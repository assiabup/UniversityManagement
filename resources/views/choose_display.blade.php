@extends('contenue')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Choix d'Affichage</h1>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mb-3" style="background-image: linear-gradient(to bottom right, #3498db, #1abc9c);">
                <div class="card-body">
                    <h5 class="card-title text-white">Afficher la Session Normale</h5>
                    <p class="card-text text-white">Afficher les données de la session normale.</p>
                    <a href="{{ route('selectFiliereNiveauForm') }}" class="btn btn-primary">Afficher</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-3" style="background-image: linear-gradient(to bottom right, #9b59b6, #e74c3c);">
                <div class="card-body">
                    <h5 class="card-title text-white">Afficher les Résultats Finaux</h5>
                    <p class="card-text text-white">Afficher les résultats finaux des étudiants.</p>
                    <a href="{{ route('results.index') }}" class="btn btn-primary">Afficher</a>
                </div>
            </div>
        </div>
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
        max-width: 800px; /* Largeur maximale du conteneur */
    }

    .card {
        border: none; /* Supprimer la bordure de la carte */
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); /* Ajouter une ombre */
        transition: box-shadow 0.3s ease-in-out; /* Animation de transition pour l'ombre */
    }

    .card:hover {
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2); /* Augmenter l'ombre au survol */
    }

    .card-title {
        color: #fff; /* Couleur du titre de la carte */
    }

    .card-text {
        color: #fff; /* Couleur du texte de la carte */
    }
</style>
@endsection