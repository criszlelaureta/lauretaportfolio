@props(['stat' => null])

<div class="stat-card reveal">
    <span class="stat-card__value">{{ $stat['value'] ?? '' }}</span>
    <span class="stat-card__label">{{ $stat['label'] ?? '' }}</span>
</div>
