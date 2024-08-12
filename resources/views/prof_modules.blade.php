@extends('contenue')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">Modules pour le Niveau: {{ $niveau->name }}</h1>
    <h2 class="text-center mb-4">Filière: {{ $filiere->name }}</h2>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($modules as $module)
                            <li class="list-group-item d-flex justify-content-between align-items-center module-item">
                                {{ $module->name }}
                                <a href="{{ route('modules.courses1', ['moduleId' => $module->id]) }}" class="btn btn-primary">Voir les cours</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .module-item {
        background-color: #f8f9fa; /* Couleur de fond des éléments de liste */
        margin-bottom: 10px; /* Marge entre les éléments de liste */
    }

    .module-item:hover {
        background-color: #e9ecef; /* Couleur de fond au survol */
    }
</style>
@endsection