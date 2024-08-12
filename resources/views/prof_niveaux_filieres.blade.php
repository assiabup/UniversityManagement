@extends('contenue')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">Filières et Niveaux Enseignés par les Professeurs</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @php
        $lastTeacher = null;
    @endphp

    @foreach($filieres as $filiereData)
        @if($filiereData['teacher']->id !== optional($lastTeacher)->id)
            @if($lastTeacher !== null)
                </div></div>
            @endif

            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h2>Enseignant: {{ $filiereData['teacher']->name }}</h2>
                </div>
                <div class="card-body">
            @php
                $lastTeacher = $filiereData['teacher'];
            @endphp
        @endif

        <div class="mb-3">
            <h3>Filière: {{ $filiereData['field_of_study']->name }}</h3>
            <p>Niveaux:</p>
            <ul class="list-group">
                @foreach($filiereData['levels'] as $level)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $level->name }}
                        <a href="{{ route('prof.modules1', ['niveauId' => $level->id, 'filiereId' => $filiereData['field_of_study']->id]) }}" class="btn btn-primary btn-sm">
                            Voir Modules
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach

    @if($lastTeacher !== null)
        </div></div>
    @endif
</div>

<style>
    .card-header {
        background-color: #007bff;
        color: #fff;
    }

    .card-body h3 {
        margin-bottom: 10px;
    }

    .list-group-item {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
    }

    .list-group-item:hover {
        background-color: #e9ecef;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
</style>
@endsection