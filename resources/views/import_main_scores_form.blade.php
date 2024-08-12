@extends('contenue')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Importer les Notes de l'Examen Principal</div>

                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if(session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="{{ route('importe_grades') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="file">Sélectionner le fichier Excel des notes :</label>
                                <input type="file" name="file" class="form-control-file">
                            </div>

                            <button type="submit" class="btn btn-primary">Importer les Notes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
