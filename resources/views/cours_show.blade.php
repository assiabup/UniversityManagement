@extends('contenue')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center bg-primary text-white">
                <h1>Cours du Module : {{ $module->name }}</h1>
            </div>
            <div class="card-body">
                <p class="card-text">Liste des cours associés à ce module :</p>

                @if($cours->isEmpty())
                    <div class="alert alert-warning text-center" role="alert">
                        Aucun cours disponible pour ce module.
                    </div>
                @else
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Titre du Cours</th>
                                <th>Type de Cours</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cours as $coursItem)
                                @php
                                    $userRole = auth()->user()->role ?? null;
                                    $isArchived = $coursItem->archived;
                                @endphp
                                @if ($userRole === 0 && !$isArchived)
                                    <tr>
                                        <td>{{ $coursItem->title }}</td>
                                        <td>{{ $coursItem->type }}</td>
                                        <td>
                                            <a href="{{ route('download.course', ['courseId' => $coursItem->id]) }}" class="btn btn-sm btn-primary">Télécharger</a>
                                        </td>
                                    </tr>
                                @elseif ($userRole === 1)
                                    @if ($isArchived)
                                        <tr class="table-warning">
                                            <td>{{ $coursItem->title }}</td>
                                            <td>{{ $coursItem->type }}</td>
                                            <a href="{{ route('download.course', ['courseId' => $coursItem->id]) }}" class="btn btn-sm btn-primary">Télécharger</a>
                                                <form action="{{ route('courses.unarchive', ['courseId' => $coursItem->id]) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success">Désarchiver</button>
                                                </form>
                                                <form action="{{ route('courses.destroy', ['courseId' => $coursItem->id]) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')">Supprimer</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td>{{ $coursItem->title }}</td>
                                            <td>{{ $coursItem->type }}</td>
                                            <td>
                                            <a href="{{ route('download.course', ['courseId' => $coursItem->id]) }}" class="btn btn-sm btn-primary">Télécharger</a>
                                                <form action="{{ route('courses.archive', ['courseId' => $coursItem->id]) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-warning">Archiver</button>
                                                </form>
                                                <form action="{{ route('courses.destroy', ['courseId' => $coursItem->id]) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')">Supprimer</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection