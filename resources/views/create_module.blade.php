@extends('contenue')
@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('modules.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="field_of_study_id">Choisir la filière :</label>
        <select name="field_of_study_id" id="field_of_study_id" class="form-control">
            @foreach ($fieldOfStudies as $filiere)
                <option value="{{ $filiere->id }}">{{ $filiere->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="name">Nom du module :</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="name">le Code  :</label>
        <input type="text" name="code" id="code" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="description">Description du module :</label>
        <textarea name="description" id="description" class="form-control" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Ajouter Module</button>
</form>






@endsection