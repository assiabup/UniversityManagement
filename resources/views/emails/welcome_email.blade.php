<!DOCTYPE html>
<html>
<head>
    <title>Bienvenue sur notre plateforme</title>
</head>
<body>
    <h1>Bienvenue, {{ $name }} !</h1>
    <p>Votre compte a été créé avec succès. Voici vos informations de connexion :</p>
    <ul>
        <li><strong>Nom :</strong> {{ $name }}</li>
        <li><strong>E-mail :</strong> {{ $email }}</li>
        <li><strong>Mot de passe :</strong> {{ $password }}</li>
    </ul>
    <p>Connectez-vous avec ce mot de passe et changez-le dès votre première connexion.</p>
</body>
</html>
