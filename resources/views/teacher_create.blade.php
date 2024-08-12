<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un enseignant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nom :</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail :</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label for="department" class="form-label">Département :</label>
                <input type="text" id="department" name="department" class="form-control" value="{{ old('department') }}">
            </div>

            <div class="mb-3">
                <label for="field_of_studies" class="form-label">Domaine d'études :</label>
                <select id="field_of_studies" name="field_of_studies[]" class="form-select select2" multiple>
                    @foreach($fieldOfStudies as $fieldOfStudy)
                        <option value="{{ $fieldOfStudy->id }}">{{ $fieldOfStudy->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="levels" class="form-label">Niveaux :</label>
                <select id="levels" name="levels[]" class="form-select select2" multiple></select>
            </div>

            <div class="mb-3">
                <label for="modules" class="form-label">Modules :</label>
                <select id="modules" name="modules[]" class="form-select select2" multiple></select>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image :</label>
                <input type="file" id="image" name="image" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Créer</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                width: '100%'
            });

            $('#field_of_studies').change(function() {
                var fieldOfStudyIds = $(this).val();
                $.ajax({
                    url: '/get-levels',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        field_of_study_ids: fieldOfStudyIds
                    },
                    success: function(data) {
                        $('#levels').empty();
                        data.levels.forEach(function(level) {
                            $('#levels').append(new Option(level.name, level.id));
                        });
                        // Reinitialize Select2 for new options
                        $('#levels').select2({
                            width: '100%'
                        });
                    }
                });
            });

            $('#levels').change(function() {
                var levelIds = $(this).val();
                $.ajax({
                    url: '/get-modules',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        level_ids: levelIds
                    },
                    success: function(data) {
                        $('#modules').empty();
                        data.modules.forEach(function(module) {
                            $('#modules').append(new Option(module.name, module.id));
                        });
                        // Reinitialize Select2 for new options
                        $('#modules').select2({
                            width: '100%'
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>