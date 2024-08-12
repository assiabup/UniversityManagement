@extends('contenue')
@section('content')
<style>
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}
table, th, td {
    border: 1px solid #ddd;
}
th, td {
    padding: 10px;
    text-align: left;
}
th {
    background-color: #f2f2f2;
}
img {
    max-width: 100px;
    height: auto;
}
.view-button {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 4px;
    margin-right: 5px;
}
</style>
@if(count($students) > 0)
    <h2>Liste des étudiants :</h2>
    

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>CNE</th>
            @if(auth()->user()->role ==1)
            <th>Actions</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $student)
            <tr>
                <td>{{ $student->name }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->cne }}</td>
                @if(auth()->user()->role ==1)
                <td>
                    <a href="{{ route('students.details', $student->id) }}" class="view-button">Voir Détails</a>
                </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
@else
    <p>Aucun étudiant trouvé.</p>
@endif

@endsection