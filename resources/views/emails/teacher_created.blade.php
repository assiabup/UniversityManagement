@component('mail::message')
# Bienvenue sur notre plateforme

Bonjour {{ $teacher->name }},

Votre compte professeur a été créé avec succès sur notre plateforme. Voici vos informations de connexion :

- **Nom:** {{ $teacher->name }}
- **E-mail:** {{ $teacher->email }}
- **Mot de passe:** {{ $password }}

Nous vous recommandons de vous connecter avec ce mot de passe et de le changer dès votre première connexion.

Merci de vous être inscrit sur notre plateforme !

Cordialement,<br>
L'équipe de notre plateforme
@endcomponent
