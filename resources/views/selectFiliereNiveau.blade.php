@extends('contenue')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Sélectionner la Filière et le Niveau</h1>

    <form method="POST" action="{{ route('showStudentGrades') }}">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Choisir une Filière :</h5>
                        <select class="form-control mb-3" id="filiere" name="filiere">
                            @foreach($filieres as $filiere)
                                <option value="{{ $filiere->id }}">{{ $filiere->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Choisir un Niveau :</h5>
                        <select class="form-control mb-3" id="niveau" name="niveau">
                            @foreach($niveaux as $niveau)
                                <option value="{{ $niveau->id }}">{{ $niveau->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-lg">Afficher les Notes</button>
        </div>
    </form>
</div>
@endsection

@section('styles')
<style>
    body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
    }

    .container {
        max-width: 800px;
    }

    .card {
        border: none;
        transition: box-shadow 0.3s ease-in-out;
    }

    .card:hover {
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
    }

    .card-title {
        color: #343a40;
        margin-bottom: 1rem;
    }

    .form-control {
        border-color: #ced4da;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
</style>
@endsection