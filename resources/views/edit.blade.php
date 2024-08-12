<!-- resources/views/students/edit.blade.php -->

@extends('contenue')

@section('content')
    <h1>Modifier les informations de l'étudiant</h1>
    <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div>
        <label for="name">Nom :</label>
        <input type="text" id="name" name="name" value="{{ $student->name }}" required>
    </div>

    <div>
        <label for="email">E-mail :</label>
        <input type="email" id="email" name="email" value="{{ $student->email }}" required>
    </div>

    <div>
        <label for="cne">CNE :</label>
        <input type="text" id="cne" name="cne" value="{{ $student->cne }}" required>
    </div>

    <div>
    <label for="field_of_study">Champ d'études (Filière) :</label>
    <input type="text" id="field_of_study" name="field_of_study" value="{{ $student->fieldOfStudy->name ?? '' }}" required>
</div>

    <div>
        <label for="level">Niveau :</label>
        <input type="text" id="level" name="level" value="{{ $student->level->name ?? '' }}" required>
    </div>

    <div>
        <label for="image">Nouvelle Image :</label>
        <input type="file" id="image" name="image">
    </div>

    <button type="submit">Enregistrer les modifications</button>
</form>
@endsection 
