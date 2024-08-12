@extends('contenue')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Importer des Notes de Rattrapage</h1>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('store_rattrapage') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="file" class="font-weight-bold">Sélectionner un fichier Excel :</label>
                <input type="file" class="form-control-file" id="file" name="file">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Importer</button>
        </form>
    </div>
@endsection

@section('styles')
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
    }

    .container {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        color: #007bff;
        margin-bottom: 30px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }

    .alert {
        margin-top: 20px;
    }

    .form-group label {
        color: #333;
    }

    .form-control-file {
        padding: 10px;
        border: 1px solid #ced4da;
        border-radius: 5px;
        transition: border-color 0.3s;
    }

    .form-control-file:focus {
        border-color: #007bff;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        padding: 10px 20px;
        transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .btn-primary:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
    }
</style>
@endsection