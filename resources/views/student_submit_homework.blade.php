<!-- resources/views/student_submit_homework.blade.php -->

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
<div class="container">
    <h2>Soumettre un devoir</h2>
    <form method="POST" action="{{ route('student.submitHomework') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
    <label for="module_id">Choisir un module :</label>
    <select class="form-control" id="module_id" name="module_id">
        @foreach ($modules as $module)
            <option value="{{ $module->id }}">{{ $module->name }}</option>
        @endforeach
    </select>
    @error('module_id')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="homework_pdf">Télécharger le devoir (PDF) :</label>
    <input type="file" class="form-control-file" id="homework_pdf" name="homework_pdf">
@error('homework_pdf')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
</div>

        <button type="submit" class="btn btn-primary">Soumettre le devoir</button>
    </form>
</div>
@endsection