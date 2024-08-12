@extends('contnue')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@section('content')
<form action="{{ route('courses.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
        <label for="file">Sélectionner le fichier PDF :</label>
        <input type="file" name="file" id="file">
    </div>

    <div>
        <label for="module_id">Sélectionner le module :</label>
        <select name="module_id" id="module_id">
            @foreach($modules as $module)
                <option value="{{ $module->id }}">{{ $module->name }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit">Importer</button>
</form>

@endsection 