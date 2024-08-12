@extends('contenue')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-5">Notifications</h2>
    @if($notifications->isEmpty())
        <p>Aucune notification pour le moment.</p>
    @else
        <p>Total des notifications : <strong>{{ $totalNotifications }}</strong> </p>
        <table class="table table-bordered">
            <thead class="table-primary">
                <tr>
                    <th scope="col">Titre</th>
                    <th scope="col">Date</th>
                    <th scope="col">Lien</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notifications as $notification)
                    <tr class="{{ $notification->read ? 'notification-read' : 'notification-unread' }}">
                        <td><strong>{{ $notification->message }}</strong></td>
                        <td>{{ $notification->created_at->format('d M Y H:i') }}</td>
                        <td>
                        @if ($notification->message === "Affichage de note")
                            <a href="{{ route('grades.student', ['id' => $notification->user_id]) }}" class="btn btn-primary btn-sm">Voir</a>
                        @elseif ($notification->message === "Une nouvelle annonce a été publiée.")
                            <a href="{{ route('annonces.index')}}" class="btn btn-primary btn-sm">Voir</a>
                        @elseif ($notification->message === "Un cour a été publié")
                            <a href="{{ route('Module_filiere')}}" class="btn btn-primary btn-sm">Voir</a>
                        @endif
                    </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Pagination -->
        @if($notifications instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <!-- Liens vers les numéros de page -->
                @for ($i = 1; $i <= $notifications->lastPage(); $i++)
                    <li class="page-item {{ $i == $notifications->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $notifications->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
            </ul>
        </nav>
        @endif
    @endif
</div>
@endsection
