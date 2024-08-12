@extends('contenue')

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4">Modules enseignés</h2>
    <div class="list-group">
        @foreach ($modules as $module)
            <a href="{{ route('professor.submissions', ['moduleId' => $module->id]) }}" class="list-group-item list-group-item-action module-item">
                {{ $module->name }}
            </a>
        @endforeach
    </div>
</div>

<style>
    .module-item {
        background-color: #f8f9fa; /* Couleur de fond des éléments de liste */
        color: #495057; /* Couleur du texte */
        border: 1px solid #dee2e6; /* Bordure des éléments de liste */
        transition: background-color 0.3s, color 0.3s; /* Transition pour les effets */
        margin-bottom: 10px; /* Marge entre les éléments de liste */
    }

    .module-item:hover {
        background-color: #e9ecef; /* Couleur de fond au survol */
        color: #212529; /* Couleur du texte au survol */
        border-color: #ced4da; /* Couleur de la bordure au survol */
    }

    .module-item:active {
        background-color: #d6d8db; /* Couleur de fond lorsqu'on clique */
        color: #212529; /* Couleur du texte lorsqu'on clique */
        border-color: #c6c8ca; /* Couleur de la bordure lorsqu'on clique */
    }
</style>
@endsection