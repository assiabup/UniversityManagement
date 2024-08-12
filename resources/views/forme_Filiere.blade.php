@extends('contenue')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Créer une Nouvelle Filière</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('create_Filiere') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name">Nom de la Filière :</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="disription">Description :</label>
                        <input type="text" class="form-control" id="disription" name="disription" required>
                    </div>
                    <div class="form-group mb-3" id="levels-container">
                        <label for="levels">Niveaux :</label>
                        <div class="level-input mb-2">
                            <input type="text" class="form-control" name="levels[]" required>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <button type="button" class="btn btn-outline-primary me-2" id="add-level">Ajouter Niveau</button>
                        <button type="button" class="btn btn-outline-danger" id="remove-level">Supprimer Niveau</button>
                    </div>
                    <button type="submit" class="btn btn-success">Créer Filière</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('add-level').addEventListener('click', function() {
                var levelsContainer = document.getElementById('levels-container');
                var newDiv = document.createElement('div');
                newDiv.setAttribute('class', 'level-input mb-2');
                newDiv.innerHTML = '<input type="text" class="form-control" name="levels[]">';
                levelsContainer.appendChild(newDiv);
            });

            document.getElementById('remove-level').addEventListener('click', function() {
                var levelsContainer = document.getElementById('levels-container');
                var levelInputs = levelsContainer.getElementsByClassName('level-input');
                if (levelInputs.length > 1) {
                    levelsContainer.removeChild(levelInputs[levelInputs.length - 1]);
                }
            });
        });
    </script>

    <style>
        .card-header {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-outline-primary,
        .btn-outline-danger {
            flex: 1;
        }
    </style>
@endsection