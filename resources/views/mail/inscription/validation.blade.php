@component('mail::message')
# Bonjour

Vous avez été inscrit sur l'application Express Courrier par {{ $sender->nom_complet }}.
Veuillez cliquer sur le boutton ci-dessous pour valider l'inscription.

@component('mail::button', ['url' => $url])
Valider l'inscription
@endcomponent

Cordialement,<br>
Open2sw
<!-- {{ config('app.name') }} -->
@endcomponent
