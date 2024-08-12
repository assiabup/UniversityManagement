@extends('contenue')

@section('content')
<div class="container">
    <h1>Liste des Filières</h1>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Numéro</th>
                <th scope="col">Nom</th>
                <th scope="col">Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fieldofstudys as $index => $filiere)
            <tr>
                <th scope="row">{{ $index + 1 }}</th>
                <td>{{ $filiere->name }}</td>
                <td>{{ $filiere->disription }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
