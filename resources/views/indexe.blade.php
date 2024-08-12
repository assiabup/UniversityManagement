@extends('contenue')
@section('content')
@foreach ($modules as $module)
    <p>{{ $module->nom }}</p>

    @if ($module->cours && $module->cours->count() > 0)
        <ul>
            @foreach ($module->cours as $cours)
                <li>{{ $cours->titre }}</li>
            @endforeach
        </ul>

        <!-- Ajouter un lien pour afficher les cours par module -->
        <a href="{{ route('show.cours.by.module', ['moduleId' => $module->id]) }}">Voir les cours par module</a>
    @endif
@endforeach
@endsection