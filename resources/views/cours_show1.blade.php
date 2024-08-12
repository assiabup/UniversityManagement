@extends('contenue')

@section('content')
<div class="container">
    <h1>Cours du Module: {{ $module->name }}</h1>

    <!-- Bouton pour ajouter un nouveau cours -->
    <div class="mb-3">
        <a href="{{ route('cours.create1', ['moduleId' => $module->id]) }}" class="btn btn-primary">Ajouter un cours</a>
    </div>

    <!-- Liste des cours existants -->
    <ul class="list-group">
        @foreach($cours as $course)
        <!-- Vérifier le rôle de l'utilisateur -->
        @if(auth()->user()->role == 2 || !$course->archived)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $course->title }} - {{ $course->type }}
                @if($course->archived)
                    <span class="badge bg-secondary rounded-pill">Archivé</span>
                @endif

                <!-- Actions pour chaque cours -->
                <div>
                    <!-- Formulaire de suppression -->
                    <form action="{{ route('cours.destroy1', ['courseId' => $course->id]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>

                    <!-- Formulaire pour archiver/désarchiver -->
                    @if($course->archived)
                        <form action="{{ route('cours.unarchive1', ['courseId' => $course->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-warning">Désarchiver</button>
                        </form>
                    @else
                        <form action="{{ route('cours.archive1', ['courseId' => $course->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-secondary">Archiver</button>
                        </form>
                    @endif
                </div>
            </li>
        @endif
        @endforeach
    </ul>
</div>
@endsection