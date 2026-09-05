@props([
    'eyebrow' => null,
    'title' => null,
    'lead' => null,
    'icon' => null,
])

<div class="section-heading">
    @if($eyebrow)
        <span class="section-heading__eyebrow">
            @if($icon) <x-icons.icon :name="$icon" /> @endif
            {{ $eyebrow }}
        </span>
    @endif
    @if($title)
        <h2 class="section-heading__title">{{ $title }}</h2>
    @endif
    @if($lead)
        <p class="section-heading__lead">{{ $lead }}</p>
    @endif
</div>
