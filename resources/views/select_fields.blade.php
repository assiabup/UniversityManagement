@extends('contenue')
@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Sélection des Étudiants</h1>
        
        <form method="POST" action="{{route('students.index1')}}" class="p-4 border rounded shadow-sm bg-white">
            @csrf

            <div class="mb-3">
                <label for="field_of_study" class="form-label">Filière :</label>
                <select name="field_of_study" id="field_of_study" class="form-select">
                    <option value="">Sélectionner une filière</option>
                    @foreach ($fieldsOfStudy as $field)
                        <option value="{{ $field->name }}">{{ $field->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="level" class="form-label">Niveau :</label>
                <select name="level" id="level" class="form-select" disabled>
                    <option value="">Sélectionner d'abord une filière</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Afficher les Étudiants</button>
        </form>
    </div>

    <script>
        document.getElementById('field_of_study').addEventListener('change', function() {
            const fieldOfStudy = this.value;
            const levels = {!! json_encode($levelsByFieldOfStudy) !!};

            const levelSelect = document.getElementById('level');
            levelSelect.innerHTML = '<option value="">Sélectionner un niveau</option>';

            if (levels[fieldOfStudy]) {
                levels[fieldOfStudy].forEach(function(level) {
                    const option = document.createElement('option');
                    option.value = level.name;
                    option.textContent = level.name;
                    levelSelect.appendChild(option);
                });

                levelSelect.disabled = false;
            } else {
                levelSelect.disabled = true;
            }
        });
    </script>

    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
        }
        h1 {
            color: #343a40;
        }
        .form-label {
            font-weight: bold;
            color: #495057;
        }
        .form-select {
            border-color: #ced4da;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .border {
            border: 1px solid #ced4da !important;
        }
        .shadow-sm {
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
        }
    </style>
@endsection