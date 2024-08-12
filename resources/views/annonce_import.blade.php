@extends('contenue')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Annonces</div>

                <div class="card-body">
                    @foreach ($annonces as $annonce)
                        <div>{{ $annonce->file_name }}</div>
                        <!-- Ajoutez ici un lien pour télécharger le fichier -->
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
