@php
    $map = [
        'high'   => ['label' => 'Haute',   'class' => 'badge-haute'],
        'medium' => ['label' => 'Moyenne', 'class' => 'badge-moyenne'],
        'low'    => ['label' => 'Basse',   'class' => 'badge-basse'],
    ];
    $s = $map[$priorite] ?? ['label' => $priorite, 'class' => 'badge-neutre'];
@endphp
<span class="badge {{ $s['class'] }}">{{ $s['label'] }}</span>
