@extends('contenue')

@section('content')

<table class="table">
  <thead>
    <tr>
      <th scope="col">Num</th>
      <th scope="col">Nom</th>
      <th scope="col">Code</th>
      <th scope="col">Description</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($module1 as $index => $mod)
    <tr>
      <th scope="row">{{ $index + 1 }}</th>
      <td>{{ $mod->name }}</td>
      <td>{{ $mod->code }}</td>
      <td>{{ $mod->description }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
