@extends('contenue')
@section('content')
    <p>{{ $module->nom }} assiatajri</p>
    @if ($module->cours->isNotEmpty())
        <ul>
            @foreach ($module->cours as $cour)
                <li>{{ $cour->title }}</li>
                <form method="POST" action="{{ route('courses.archive', ['id' => $cour->id]) }}" style="display: inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-warning">Archiver</button>
                </form>
                <form method="POST" action="{{ route('course.restore', ['id' => $cour->id]) }}" style="display: inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success">Restaurer</button>
                </form>
                {{-- Bouton de téléchargement --}}
                <a href="{{ route('download.course', ['courseId' => $cour->id]) }}" class="btn btn-primary">Télécharger</a>
            @endforeach
        </ul>
    @else
        <p>Aucun cours trouvé pour ce module.</p>
    @endif
@endsection