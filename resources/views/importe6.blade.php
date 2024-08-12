<!-- resources/views/grades/import.blade.php -->

@extends('contenue')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Importer les notes  de session normal a  partir d'un fichier Excel</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('grades.import.post') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="file">Sélectionner le fichier Excel :</label>
                                <input type="file" name="file" class="form-control-file">
                            </div>
                            <button type="submit" class="btn btn-primary">Importer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection