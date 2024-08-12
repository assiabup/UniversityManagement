@extends('contenue')


@section('content')
<div class="container">
    <h1>Liste des Absences</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Modules</th>
                <th>Étudiants</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absences as $absence)
                <tr>
                    <!-- Utilisez Carbon pour formater la date si elle est de type string -->
                    <td>{{ \Carbon\Carbon::parse($absence->absence_date)->format('d/m/Y') }}</td>
                    <td>
                        @foreach($absence->modules as $module)
                            {{ $module->name }}@if(!$loop->last), @endif
                        @endforeach
                    </td>
                    <td>
                        @foreach($absence->students as $student)
                            {{ $student->name }}@if(!$loop->last), @endif
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
