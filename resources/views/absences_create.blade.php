@extends('contenue')

@section('content')
<style>
    table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}
table, th, td {
    border: 1px solid #ebe1e1f3;
}
th, td {
    padding: 10px;
    text-align: left;
}
th {
    background-color: #aa8cf5d3;
}
img {
    max-width: 100px;
    height: auto;
}
td.absence-checkbox {
    text-align: center;
}
.view-button {
    background-color: #e2e9ef;
    color: #fff;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 4px;
    margin-right: 5px;
}
</style>
<div class="container mt-5">
    <h1 class="text-center mb-4">Gestion des Absences</h1>
    <form action="{{ route('absences.store') }}" method="POST" class="p-4 border rounded shadow-sm bg-white">
        @csrf
        <div class="mb-3">
            <label for="absence_date" class="form-label">Date du cours</label>
            <input type="date" name="absence_date" id="absence_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="modules" class="form-label">Modules</label>
            <select class="form-select" aria-label="Module" name="modules" required>
                <option selected disabled>Sélectionnez un module</option>
                @foreach($modules as $module)
                    <option value="{{ $module->id }}">{{ $module->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="students" class="form-label">Étudiants</label>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>CNE</th>
                        <th>Email</th>
                        <th>Absence</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>{{ $student->name }}</td> <!-- Modifier selon vos colonnes de modèle -->
                            <td>{{ $student->cne }}</td> <!-- Modifier selon vos colonnes de modèle -->
                            <td> 
                                {{ $student->email }}
                            </td>
                            <td class="absence-checkbox"> 
                                <input class="form-check-input" type="checkbox" name="students[]" value="{{ $student->id }}" id="student{{ $student->id }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
       

        <button type="submit" class="btn btn-primary w-100">Enregistrer les absences</button>
    </form>
</div>
@endsection
