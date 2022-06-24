<!-- TODO: Mettre le lien approprié -->
@component('mail::message')
<h3 style="text-align: center;color: #2D3748; border-bottom: 1px solid #2D3748; margin-bottom: 30px; padding-bottom: 10px;">MINISTERE DE L'EAU ET L'ASSAINISSEMENT DU SENEGAL</h3>

Chèr(e) {{ $reaffectation->suivi_par_inscription->nom_complet }},

Nous vous informons que le courrier <b>{{ $reaffectation->cr_courrier->libelle }}</b> vous a été transmis par {{$reaffectation->inscription->nom_complet}}.

Veuillez cliquer sur le lien ci-dessous pour voir plus de détails.

@component('mail::button', ['url' => $url])
Plus de détails
@endcomponent

Cordialement,<br>
Open2sw
@endcomponent
