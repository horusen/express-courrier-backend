<!-- TODO: Mettre le lien approprié -->
@component('mail::message')
<h3 style="text-align: center;color: #2D3748; border-bottom: 1px solid #2D3748; margin-bottom: 30px; padding-bottom: 10px;">MINISTERE DE L'EAU ET L'ASSAINISSEMENT DU SENEGAL</h3>

Chèr(e) {{ $courrier->expediteur->libelle }},

Votre courrier a été rejeté à la date du {{ date_format($courrier->date_arrive, 'd-m-Y') }} pour les motifs suivant:

<b>{{ $motif }}</b>


Veuillez cliquer sur le lien ci-dessous pour voir plus de details.

@component('mail::button', ['url' => $url])
Voir courrier
@endcomponent

Cordialement,<br>
Open2sw
@endcomponent
