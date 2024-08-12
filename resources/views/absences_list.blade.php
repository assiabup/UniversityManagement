@extends('contenue')

@section('content')
<div class="container">
    <h1>Liste des absences</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>CNE</th>
                <th>Email</th>
                <th>Total Absences</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->cne }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->absences_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
