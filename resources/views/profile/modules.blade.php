@extends('contenue')

@section('content')
    <div class="container">
        <h1>Modules du Niveau</h1>
        <p>Liste des modules associés à ce niveau</p>

        <table class="table">
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
                        <td>{{$module->name}}</td>
                        <td>{{$module->description}}</td>
                        <td>
                            <a href="{{ route('modules.cours', ['moduleId' => $module->id]) }}" class="btn btn-sm btn-primary">Voir les Cours</a>
                            

                            
                           
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection