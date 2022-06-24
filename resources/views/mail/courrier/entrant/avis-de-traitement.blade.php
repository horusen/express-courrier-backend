<!-- TODO: Mettre le lien approprié -->
@component('mail::message')
<h3 style="text-align: center;color: #2D3748; border-bottom: 1px solid #2D3748; margin-bottom: 30px; padding-bottom: 10px;">MINISTERE DE L'EAU ET L'ASSAINISSEMENT DU SENEGAL</h3>

Chèr(e) {{ $courrier->expediteur->libelle }},

Nous vous informons que votre courrier <b>{{ $courrier->cr_courrier->libelle }}</b> est en cours de traitement.

Veuillez cliquer sur le lien ci-dessous pour pouvoir suivre l'etape d'evolution du traitement de votre courrier.

@component('mail::button', ['url' => $url])
Voir courrier
@endcomponent

Cordialement,<br>
Open2sw
@endcomponent
