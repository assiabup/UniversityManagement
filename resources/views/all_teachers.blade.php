@extends('contenue')

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4">Liste des Professeurs</h2>
    <br>

    @if ($teachers->isEmpty())
        <p class="text-center">Aucun professeur trouvé.</p>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover custom-table">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($teachers as $teacher)
                        <tr>
                            <td>{{ $teacher->name }}</td>
                            <td>{{ $teacher->email }}</td>
                            <td>
                                <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce professeur ?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<style>
    .custom-table {
        border-collapse: collapse;
        width: 100%;
    }

    .custom-table th, .custom-table td {
        padding: 12px;
        text-align: left;
        border: 1px solid #dee2e6;
    }

    .custom-table thead {
        background-color: #007bff;
        color: white;
    }

    .custom-table tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    .custom-table tbody tr:hover {
        background-color: #f1f1f1;
    }

    .img-thumbnail {
        border: 2px solid #dee2e6;
        border-radius: 5px;
    }

    .container {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection