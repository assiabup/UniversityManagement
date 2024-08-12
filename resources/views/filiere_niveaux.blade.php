@extends('contenue')

@section('content')
<br>
    <div class="container">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <h1>Liste des Filières avec Niveaux</h1>
            <a href="{{ route('show_forme_filiere') }}" class="btn btn-sm btn-success">Ajouter une filière</a>
        </div>
 <br>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <br>
                    <th scope="col">Nom de la Filière</th>
                    <th scope="col">Niveaux</th>
                    <th class='action' scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($filières as $filiere)
                    <tr>
                        <td>{{ $filiere->name }}</td>
                        <td>
                            <ul class="list-unstyled">
                                @foreach($filiere->levels as $level)
                                    <li>
                                        <div class="d-flex flex-column">
                                            <span>{{ $level->name }}</span>
                                            <div class="mt-1">
                                                <a href="{{ route('modules.create', ['filiereId' => $filiere->id, 'niveauId' => $level->id]) }}" class="btn btn-sm btn-primary">Ajouter un module</a>
                                                <a href="{{ route('modules.show2002', ['niveauId' => $level->id]) }}" class="btn btn-sm btn-info">Afficher les modules</a>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <form action="{{ route('filiere.destroy', $filiere->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette filière ?')" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Supprimer la filière</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <style>
        .d-flex.flex-column > span {
            font-weight: bold;
        }

        .mt-1 {
            margin-top: 0.5rem;
        }

        .table thead th {
            background-color: #f8f9fa;
            text-align: center;
        }

        .table tbody td {
            vertical-align: middle;
        }
        .action{
       padding-right : 30 px ;
        }
        .btn btn-sm btn-danger{
            padding-right : 500 px ;
        }
    </style>
@endsection