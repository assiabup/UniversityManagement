@extends('contenue')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Ajouter un Module au Niveau : {{ $level->name }}</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('modules.store', ['filiereId' => $filiereId, 'niveauId' => $niveauId]) }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="nom" class="form-label">Nom du Module :</label>
                    <input type="text" id="nom" name="nom" class="form-control" placeholder="Entrez le nom du module" required>
                </div>
                <div class="form-group mb-3">
                    <label for="code" class="form-label">Code du Module :</label>
                    <input type="text" id="code" name="code" class="form-control" placeholder="Entrez le code du module" required>
                </div>
                <div class="form-group mb-3">
                    <label for="description" class="form-label">Description :</label>
                    <textarea id="description" name="description" class="form-control" placeholder="Entrez une description du module" rows="4"></textarea>
                </div>

                <!-- Champs cachés pour les IDs -->
                <input type="hidden" name="filiereId" value="{{ $filiereId }}">
                <input type="hidden" name="niveauId" value="{{ $niveauId }}">
                <input type="hidden" name="fieldStudyId" value="{{ $fieldStudyId }}">

                <button type="submit" class="btn btn-primary btn-block">Ajouter Module</button>
            </form>
        </div>
    </div>
</div>
@endsection