@extends('contenue')

@section('content')
    <div class="container">
        <h1 class="mb-4">Mes Notes</h1>

       

        @if ($grades->isEmpty())
                    <p>Vous n'avez aucune note pour le moment.</p>
         @else
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
            
                            <th scope="col">Module</th>
                            <th scope="col">Note</th>
                            <th scope="col">Resultat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($grades as $grade)
                                <tr>
                                    <td>{{ $grade->module->name}}</td>
                                    @if( $grade->score < 7)
                                    <td style="color: red;">{{ $grade->score }}</td>
                                    @else
                                    <td>{{ $grade->score }}</td>
                                    @endif
                                    @if($grade->is_pass ==1)
                                    <td>Valide</td>
                                   
                                        
                                    @else
                                    <td style="color: red;">Rattrapage</td>
                                    @endif
                                   
                                </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        @endif
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