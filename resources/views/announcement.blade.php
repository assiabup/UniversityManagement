@extends('contenue')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Toutes les annonces</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date de publication</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($annonces as $annonce)
                        <tr>
                            <td>{{ $annonce->created_at }}</td>
                            <td>
                                <a href="{{ route('annonces.download', ['id' => $annonce->id]) }}" class="btn btn-sm btn-primary">Télécharger</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div>
</div>
@endsection
