@extends('contenue')

@section('content')
<div class="container">
    <br>
    <h2>Modules pour la filière {{ $fieldOfStudy->name }} - Niveau {{ $level->name }}</h2>

    @if ($modules->isEmpty())
        <p>Aucun module trouvé pour ce niveau et cette filière.</p>
    @else
    <br>
        <div class="table-responsive">
            <table class="table custom-table">
                <thead>
                    <tr>
                        <th class="bg-primary text-white">Module</th>
                        <th class="bg-primary text-white">Professeur</th>
                        <th class="bg-primary text-white">Email</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($modules as $module)
                    <tr>
                        <td>{{ $module->name }}</td>
                        <td>
                            @if ($module->teachers->isNotEmpty())
                                @foreach ($module->teachers as $teacher)
                                    {{ $teacher->name }}
                                @endforeach
                            @else
                                Aucun professeur associé
                            @endif
                        </td>
                        <td>
                            @if ($module->teachers->isNotEmpty())
                                @foreach ($module->teachers as $teacher)
                                    {{ $teacher->email }}
                                @endforeach
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<style>
    .custom-table {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #ddd;
    }

    .custom-table th, .custom-table td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    .custom-table th {
        text-align: left;
    }

    .custom-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .custom-table tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>
@endsection