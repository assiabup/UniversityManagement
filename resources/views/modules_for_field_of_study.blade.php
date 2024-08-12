<!-- resources/views/modules_for_field_of_study.blade.php -->

@extends('contenue')

@section('content')
    <h1>Modules pour la filière : {{ $fieldOfStudy->name }}</h1>

    @if ($modules->isNotEmpty())
        <ul>
            @foreach ($modules as $module)
                <li>
                    <a href="{{route('load.module.courses')}}" class="module-link" data-module-id="{{ $module->id }}">
                        {{ $module->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <p>Aucun module trouvé pour cette filière.</p>
    @endif

    <div id="module-courses-container">
        <!-- Conteneur pour afficher les cours du module sélectionné -->
    </div>
@endsection

@section('scripts')
    <script>
        // Attacher un gestionnaire d'événements pour les liens de module
        document.addEventListener('DOMContentLoaded', function () {
            const moduleLinks = document.querySelectorAll('.module-link');

            moduleLinks.forEach(link => {
                link.addEventListener('click', function (event) {
                    event.preventDefault();

                    const moduleId = this.dataset.moduleId;
                    loadModuleCourses(moduleId);
                });
            });

            function loadModuleCourses(moduleId) {
                // Requête AJAX pour charger les cours du module sélectionné
                fetch(`/load-module-courses?module_id=${moduleId}`)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('module-courses-container').innerHTML = data;
                    })
                    .catch(error => {
                        console.error('Erreur lors du chargement des cours du module :', error);
                    });
            }
        });
    </script>
@endsection
