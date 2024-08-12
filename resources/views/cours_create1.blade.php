@extends('contenue')

@section('content')
<div class="container">
    <h1>Ajouter un nouveau cours pour le module: {{ $module->name }}</h1>
    <form action="{{ route('cours.store1', ['moduleId' => $module->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Titre du cours</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="pdf_file">Fichier PDF</label>
            <input type="file" name="pdf_file" id="pdf_file" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="type">Type de cours</label>
            <input type="text" name="type" id="type" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Ajouter</button>
    </form>
</div>
@endsection