@php
    $map = [
        'to_review'          => ['label' => 'À réviser',             'class' => 'badge-candidature'],
        'interview_scheduled'=> ['label' => 'Entretien prévu',       'class' => 'badge-entretien'],
        'offer_received'     => ['label' => 'Offre reçue',           'class' => 'badge-offre'],
        'rejected'           => ['label' => 'Refusée',               'class' => 'badge-refus'],
        'abandoned'          => ['label' => 'Abandonnée',            'class' => 'badge-neutre'],
    ];
    $s = $map[$statut] ?? ['label' => $statut, 'class' => 'badge-neutre'];
@endphp
<span class="badge {{ $s['class'] }}">{{ $s['label'] }}</span>
