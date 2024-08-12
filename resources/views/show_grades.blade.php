<!-- resources/views/show_grades.blade.php -->

<h1>Notes des étudiants - Filière : {{ $fieldOfStudy->name }}</h1>

<ul>
    @foreach ($fieldOfStudy->students as $student)
        <li>{{ $student->name }} :
            @foreach ($student->grades as $grade)
                {{ $grade->subject }} : {{ $grade->score }},
            @endforeach
        </li>
    @endforeach
</ul>
