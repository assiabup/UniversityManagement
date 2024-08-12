<!-- resources/views/students_with_absences.blade.php -->

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
    <div class="container">
        <h1>Liste des étudiants avec le nombre total d'absences</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>CNE</th>
                    <th>Total Absences</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($studentsWithAbsences as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->cne }}</td>
                        <td>{{ $student->total_absences }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
