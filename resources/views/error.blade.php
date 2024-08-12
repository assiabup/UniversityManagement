<!-- resources/views/error.blade.php -->

@extends('contenue')

@section('content')
    <div class="container">
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
            <p><a href="{{ route('salam') }}" class="btn btn-primary">Retour à la page d'accueil</a></p>
        </div>
    </div>
@endsection