@extends('contenue')

@section('content')
    <div class="container">
        <h2>Créer une notification</h2>
        <form action="{{ route('annonces.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="filiere_id">Filière :</label>
                <select name="filiere_id" id="filiere_id" class="form-control">
                    <option value="">Toutes les filières</option>
                    @foreach ($filieres as $filiere)
                        <option value="{{ $filiere->id }}">{{ $filiere->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="niveau_id">Niveau :</label>
                <select name="niveau_id" id="niveau_id" class="form-control">
                    <option value="">Tous les niveaux</option>
                    @foreach ($niveaux as $niveau)
                        <option value="{{ $niveau->id }}">{{ $niveau->name }}</option>
                    @endforeach
                </select>
            </div>
            
            
            <div class="form-group">
                <label for="pdf_file">Fichier PDF :</label>
                <input type="file" name="pdf_file" id="pdf_file" class="form-control-file">
            </div>
        
           
        
            <button type="submit" class="btn btn-primary">Créer l'annonce</button>
       
    </div>
    
@endsection
