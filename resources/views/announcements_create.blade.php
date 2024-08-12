@extends('contenue')

@section('content')
<div class="container">
    <h2>Créer une annonce</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('annonces.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="filieres">Filières</label>
            <select name="filiere_ids[]" id="filieres" class="form-control" >
                <option value="all">Toutes les filières</option>
                @foreach($filieres as $filiere)
                    <option value="{{ $filiere->id }}">{{ $filiere->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="levels">Niveaux</label>
            <select name="level_ids[]" id="levels" class="form-control" >
                <option value="all">Tous les niveaux</option>
                @foreach($levels as $level)
                    <option value="{{ $level->id }}" data-filiere="{{ $level->field_of_study_id }}">{{ $level->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="annonce_pdf">Fichier PDF</label>
            <input type="file" name="annonce_pdf" id="annonce_pdf" class="form-control" required>
        </div>
        <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary w-100">Créer l'annonce</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const filieresSelect = document.getElementById('filieres');
    const levelsSelect = document.getElementById('levels');

    const allLevelsOption = levelsSelect.querySelector('option[value="all"]');
    const levelsOptions = Array.from(levelsSelect.querySelectorAll('option:not([value="all"])'));

    function updateLevels() {
        const selectedFilieres = Array.from(filieresSelect.selectedOptions).map(option => option.value);

        if (selectedFilieres.includes('all')) {
            allLevelsOption.selected = true;
            levelsOptions.forEach(option => {
                option.selected = false;
                option.style.display = 'none';
            });
        } else {
            allLevelsOption.selected = false;
            levelsOptions.forEach(option => {
                const filiereId = option.getAttribute('data-filiere');
                if (selectedFilieres.includes(filiereId)) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });
        }
    }

    filieresSelect.addEventListener('change', function () {
        updateLevels();
        selectAllLevelsForSelectedFilieres();
    });

    function selectAllLevelsForSelectedFilieres() {
        const selectedFilieres = Array.from(filieresSelect.selectedOptions).map(option => option.value);
        
        if (!selectedFilieres.includes('all')) {
            levelsOptions.forEach(option => {
                const filiereId = option.getAttribute('data-filiere');
                if (selectedFilieres.includes(filiereId)) {
                    option.selected = true;
                } else {
                    option.selected = false;
                }
            });
        }
    }

    updateLevels();
});
</script>
@endsection
