@extends('contenue')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header text-center">
            <h1>Modules du Niveau</h1>
        </div>
        <div class="card-body">
            <p class="card-text">Liste des modules associés à ce niveau :</p>

            @if($modules->isEmpty())
                <div class="alert alert-warning text-center" role="alert">
                    Aucun module disponible pour ce niveau.
                </div>
            @else
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nom du Module</th>
                            <th scope="col">Description</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modules as $module)
                            <tr>
                                <td>{{ $module->name }}</td>
                                <td>{{ $module->description }}</td>
                                <td>
                                    <a href="{{ route('modules.cours', ['moduleId' => $module->id]) }}" class="btn btn-sm btn-primary">Voir les Cours</a>
                                    <a href="{{ route('cours.create', ['moduleId' => $module->id]) }}" class="btn btn-sm btn-success">Ajouter un Cours</a>
                                    <form action="{{ route('modules.destroy', ['moduleId' => $module->id]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce module ?')">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

<style>
    .container {
        margin-top: 20px;
    }

    .card-header {
        background-color: #007bff;
        color: white;
    }

    .table {
        margin-top: 20px;
    }

    .btn-sm {
        margin-right: 5px;
    }

    .alert {
        margin-top: 20px;
    }
</style>
@endsection