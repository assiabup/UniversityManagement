@extends('contenue')

@section('content')
<div class="container">
    <h2>Deliberation</h2>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                <th>Module</th>
                <th>Note Normale</th>
                
                <th>Note Finale</th>
                <th>Resultat</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($finalGrades as $grade)
            <tr>
                <td>{{ $grade['module'] }}</td>
                <td>{{ $grade['score_normale'] }}</td>
                <td>{{ $grade['score_final'] }}</td>
                @if( $fieldOfStudy === "cycle preparatoire" && $grade['score_final'] == 10 )
                <td>VAR</td>
                @elseif($fieldOfStudy === "cycle preparatoire" && $grade['score_normale'] >=10 && $grade['score_final'] != "-" )
                <td>V</td>
                @elseif($fieldOfStudy === "cycle preparatoire" && $grade['score_final'] < 10 && $grade['score_final'] > 7 && $grade['score_final'] != "-" )
                <td style="color: red;">NV</td>
                @elseif($fieldOfStudy === "cycle preparatoire"  && $grade['score_final'] < 7 && $grade['score_final'] != "-" )
                <td style="color: red;">NE</td>
                @elseif($grade['score_final'] < 12 && $grade['score_final'] != "-")
                <td style="color: red;">NV</td>
                @elseif($grade['score_final']==="-" &&  $grade['score_normale'] >= 12)
                <td>V</td>
                @else 
                <td>VAR</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('styles')
<style>
    body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
    }

    h1 {
        color: #343a40;
    }

    .text-muted {
        color: #6c757d;
    }

    .alert {
        margin-top: 20px;
    }

    .table {
        margin-top: 20px;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .table th {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 123, 255, 0.05);
    }

    .table-striped tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.1);
    }

    .text-success {
        color: #28a745;
    }

    .text-danger {
        color: #dc3545;
    }
</style>
@endsection