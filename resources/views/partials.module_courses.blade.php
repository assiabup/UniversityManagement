<!-- resources/views/partials/module_courses.blade.php -->

@if ($courses->isNotEmpty())
    <ul>
        @foreach ($courses as $course)
            <li>{{ $course->title }}</li>
        @endforeach
    </ul>
@else
    <p>Aucun cours trouvé pour ce module.</p>
@endif
