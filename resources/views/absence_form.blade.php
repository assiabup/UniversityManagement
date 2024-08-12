@extends('contenue')

@section('content')
    <form action="{{ route('saveAbsences') }}" method="POST">
        @csrf
        
        <label for="module">Module :</label>
        <select name="module" id="moduleSelect">
            <option value="">Sélectionnez un module</option>
            @foreach ($modules as $module)
                <option value="{{ $module->id }}">{{ $module->name }}</option>
            @endforeach
        </select>
        
        <div id="studentsList" style="display: none;">
            <label for="absence_date">Date d'absence :</label>
            <input type="date" name="absence_date" required>
            
            <label for="students">Étudiants absents :</label>
            @foreach ($students as $student)
                <div>
                    <input type="checkbox" name="absent_students[]" value="{{ $student->id }}">
                    <label>{{ $student->name }}</label>
                </div>
            @endforeach
        </div>

        <button type="submit" id="submitButton" style="display: none;">Enregistrer les absences</button>
    </form>

    <script>
        document.getElementById('moduleSelect').addEventListener('change', function() {
            const moduleId = this.value;
            if (moduleId !== '') {
                document.getElementById('studentsList').style.display = 'block';
                document.getElementById('submitButton').style.display = 'block';
            } else {
                document.getElementById('studentsList').style.display = 'none';
                document.getElementById('submitButton').style.display = 'none';
            }
        });
    </script>
@endsection
