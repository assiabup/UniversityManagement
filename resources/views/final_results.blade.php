@extends('contenue')

@section('content')
    <div class="container">
        <h1>Notes Après Rattrapage</h1>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Étudiant</th>
                    <th scope="col">Module</th>
                    <th scope="col">Note</th>
                    <th scope="col">Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach($finalResults as $note)
                    <tr>
                        <td>{{ $note->student->name }}</td>
                        <td>{{ $note->module->name }}</td>
                        <td>{{ $note->score }}</td>
                        <td>
                            @if ($note->fieldOfStudy->name === 'Cycle Préparatoire')
                                @if ($note->score >= 10)
                                    Validé
                                @elseif ($note->score > 7 && $note->score < 10)
                                    Non Validé
                                @else
                                    Ajourné
                                @endif
                            @else
                                @if ($note->score >= 12)
                                    Validé
                                @elseif ($note->score > 8 && $note->score < 12)
                                    Non Validé
                                @else
                                    Ajourné
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
