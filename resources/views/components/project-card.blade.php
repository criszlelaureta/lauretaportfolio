@props(['project' => null, 'index' => 0])

<article class="project-card reveal" data-project-index="{{ $index }}" role="button" tabindex="0" aria-label="View details for {{ $project['title'] ?? 'Project' }}">
    <div class="project-card__media">
        <img src="{{ $project['image'] ?? '' }}" alt="{{ $project['title'] ?? 'Project' }} preview" loading="lazy">
    </div>

    <div class="project-card__body">
        <h3 class="project-card__title">{{ $project['title'] ?? '' }}</h3>
        <p class="project-card__desc">{{ $project['description'] ?? '' }}</p>

        @if(!empty($project['tech']))
            <ul class="tag-list">
                @foreach($project['tech'] as $tech)
                    <li class="tag">{{ $tech }}</li>
                @endforeach
            </ul>
        @endif

        <div class="project-card__links">
            @if(!empty($project['demo']))
                <a class="btn btn--small" href="{{ $project['demo'] }}" target="_blank" rel="noopener noreferrer" onclick="event.stopPropagation()">
                    <x-icons.icon name="external" /> Live Demo
                </a>
            @endif
            @if(!empty($project['repo']))
                <a class="btn btn--ghost btn--small" href="{{ $project['repo'] }}" target="_blank" rel="noopener noreferrer" onclick="event.stopPropagation()">
                    <x-icons.social name="github" /> GitHub
                </a>
            @endif
        </div>
    </div>
</article>
