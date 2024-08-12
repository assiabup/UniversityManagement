<!-- resources/views/students/search_form.blade.php -->

@extends('contenue')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Recherche d'Étudiants</h1>
    <form action="{{ route('students.search') }}" method="POST" class="p-4 border rounded shadow-sm bg-white">
        @csrf
        <div class="mb-3">
            <label class="form-label">Rechercher par :</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="search_by" id="searchByName" value="name" checked>
                    <label class="form-check-label" for="searchByName">Nom</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="search_by" id="searchByCne" value="cne">
                    <label class="form-check-label" for="searchByCne">CNE</label>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="search_term" class="form-label">Terme de recherche :</label>
            <input type="text" name="search_term" id="search_term" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Rechercher</button>
    </form>
</div>

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
    .form-control {
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