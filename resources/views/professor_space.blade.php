@extends('contenue')
@section('content')
    <style>
        .level-card {
            background-color: #f8f9fa;
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .level-card h2 {
            margin-bottom: 20px;
        }

        .level-card p {
            margin-bottom: 20px;
        }

        .btn-toggle {
            width: 100%;
        }
    </style>

    <div class="container my-5">
        <h1 class="text-center mb-4">Espace Professeur</h1>

        @foreach ($taughtLevels as $level)
            <div class="level-card">
                <h2>{{ $level->name }}</h2>
                @if ($level->is_open)
                    <p class="text-success">Espace ouvert pour ce niveau</p>
                    <!-- Afficher un bouton pour fermer l'espace -->
                    <form method="post" action="{{ route('professor.toggleSpace', ['level_id' => $level->id, 'action' => 'close']) }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-toggle">Fermer l'espace</button>
                    </form>
                @else
                    <p class="text-danger">Espace fermé pour ce niveau</p>
                    <!-- Afficher un bouton pour ouvrir l'espace -->
                    <form method="post" action="{{ route('professor.toggleSpace', ['level_id' => $level->id, 'action' => 'open']) }}">
                        @csrf
                        <button type="submit" class="btn btn-success btn-toggle">Ouvrir l'espace</button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>

   @endsection