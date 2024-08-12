@extends('contenue')

@section('content')
<div class="container">
    <h2>Professeurs et Modules Enseignés</h2>

    @foreach($professors as $professor)
        <div class="card mb-3">
            <div class="card-header">
                <h4>{{ $professor->name }}</h4>
                <p>{{ $professor->email }}</p>
            </div>
            <div class="card-body">
                <h5>Modules Enseignés :</h5>
                <ul>
                    @foreach($professor->modules as $module)
                        <li>{{ $module->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
</div>
@endsection
