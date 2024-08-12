@extends('contenue')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Sélectionner une Filière et un Niveau</h1>

        <form method="post" action="{{ route('results.selectModule') }}">
            @csrf

            <div class="form-group">
                <label for="field_of_study">Choisir une Filière :</label>
                <select class="form-control" id="field_of_study" name="field_of_study_name">
                    @foreach($fieldOfStudies as $fieldOfStudy)
                        <option value="{{ $fieldOfStudy->name }}">{{ $fieldOfStudy->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="level">Choisir un Niveau :</label>
                <select class="form-control" id="level" name="level_id">
                    @foreach($levels as $level)
                        <option value="{{ $level->id }}">{{ $level->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Continuer</button>
        </form>
    </div>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        h1 {
            color: #007bff;
        }

        label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-primary:focus,
        .btn-primary:active {
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
    </style>
@endsection