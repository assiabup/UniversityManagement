<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'Étudiant</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .student-details {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="student-details">
        <h2>Détails de l'Étudiant</h2>
        <p><strong>Nom :</strong> {{ $student->name }}</p>
        <p><strong>Email :</strong> {{ $student->email }}</p>
        <p><strong>CNE :</strong> {{ $student->cne }}</p>
        <p><strong>Image :</strong></p>
        @if ($student->image)
            <img src="{{ asset('storage/' . $student->image) }}" alt="{{ $student->name }}">
        @else
            <p>Pas d'image disponible</p>
        @endif
    </div>
</body>
</html>