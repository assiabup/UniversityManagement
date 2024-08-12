@extends('contenue')
@section('content')


@component('mail::message')
    # Bienvenue sur notre plateforme

    Bonjour {{ $teacher->name }},

    Votre compte enseignant a été créé avec succès. Voici vos informations de connexion :

    - Identifiant : {{ $teacher->email }}
    - Mot de passe : {{ $password }}

    Vous pouvez vous connecter à notre plateforme en utilisant ces informations.

    Merci,
    L'équipe de notre plateforme
@endcomponent
@endsection
