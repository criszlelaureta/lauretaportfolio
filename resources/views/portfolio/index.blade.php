<x-layout
    :title="$profile['name'] . ' | Portfolio'"
    :profile="$profile"
    :contacts="$contacts">

    {{-- ===== HOME / HERO ===== --}}
    <section id="home" class="hero section">
        <div class="container hero__inner">
            <div class="hero__copy">
                <span class="hero__badge">Welcome to my creative space</span>
                <h1 class="hero__name">{{ $profile['name'] }}</h1>
                <p class="hero__role">{{ $profile['role'] }}</p>
                <p class="hero__tagline">{{ $profile['tagline'] }}</p>

                <div class="hero__cta">
                    <a class="btn btn--primary" href="#projects">View Projects</a>
                    <a class="btn btn--outline" href="#contact">Contact Me</a>
                </div>

                @if(!empty($contacts['links']))
                    <ul class="social-links hero__social">
                        @foreach($contacts['links'] as $link)
                            <li>
                                <a class="social-link" href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $link['label'] }}">
                                    <x-icons.social :name="$link['icon']" />
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <a href="#about" class="hero__scroll" aria-label="Scroll to About section">
            <span class="hero__scroll-line"></span>
        </a>
    </section>

    {{-- ===== ABOUT ===== --}}
    <section id="about" class="section">
        <div class="container">
            <div class="about__grid">
                <div class="about__content">
                    <x-section-heading eyebrow="A Glimpse Into Me" icon="user" />

                    <p class="about__text" style="margin-top: -1.2rem; text-align: center; color: #a7b1a5;">A little more about who I am, what I enjoy, and what keeps me curious beyond IT.</p>

                    <div class="gallery-grid">
                        <button type="button" class="gallery-grid__item" data-gallery-index="0" aria-label="View profile image 1">
                            <img src="{{ asset('img/nn.jpg') }}" alt="Profile photo" loading="lazy">
                        </button>
                        <button type="button" class="gallery-grid__item" data-gallery-index="1" aria-label="View profile image 2">
                            <img src="{{ asset('img/profile.jpg') }}" alt="Profile photo" loading="lazy">
                        </button>
                        <button type="button" class="gallery-grid__item" data-gallery-index="2" aria-label="View profile image 3">
                            <img src="{{ asset('img/pinning.jpg') }}" alt="Profile photo" loading="lazy">
                        </button>
                    </div>

                    @foreach($profile['bio'] as $paragraph)
                        <p class="about__text">{{ $paragraph }}</p>
                    @endforeach

                    <x-section-heading eyebrow="Location" icon="location" />

                    <p class="about__text" style="text-align: center; margin-top: -1rem;">{{ $profile['location'] }}</p>

                    <div style="text-align: center; margin-bottom: 2rem;">
                        <a class="btn btn--primary" href="{{ asset('files/Laureta, Criszle Resume.pdf') }}" download="Laureta, Criszle Resume.pdf" style="display: inline-flex; align-items: center; gap: .5rem;">
                            <x-icons.icon name="download" />
                            Download Resume
                        </a>
                    </div>

                    <x-section-heading eyebrow="Skills & Tools" icon="wrench" />

                    @php
                        $toolCat = collect($skills['categories'])->firstWhere('title', 'Tools & Platforms');
                        $skillCats = collect($skills['categories'])->reject(fn($c) => $c['title'] === 'Tools & Platforms');
                    @endphp
                    <div class="about-panels">
                        <div class="about-panel">
                            <div class="skill-card__head">
                                <span class="skill-card__icon"><x-icons.icon name="code" /></span>
                                <h3 class="skill-card__title">Skills</h3>
                            </div>
                            <ul class="tag-list tag-list--lg">
                                @foreach($skillCats as $cat)
                                    @foreach($cat['items'] as $skill)
                                        <li class="tag tag--skill">{{ $skill }}</li>
                                    @endforeach
                                @endforeach
                            </ul>
                        </div>
                        <div class="about-panel">
                            <div class="skill-card__head">
                                <span class="skill-card__icon"><x-icons.icon name="wrench" /></span>
                                <h3 class="skill-card__title">Tools & Frameworks</h3>
                            </div>
                            <ul class="tag-list tag-list--lg">
                                @foreach($toolCat['items'] ?? [] as $tool)
                                    <li class="tag tag--skill tool-tag">
                                        <span class="tool-tag__icon"><x-tool-logo :tool="$tool" /></span>
                                        {{ $tool }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="about__projects" id="projects">
                <x-section-heading
                    eyebrow="Projects"
                    icon="folder"
                    lead="A selection of projects I've built, from academic capstones to self-directed experiments." />

<div class="more-projects">
                    <div class="timeline timeline--projects">
                    @foreach($projects as $index => $project)
                        <div class="timeline__item reveal{{ $index >= 2 ? ' more-projects__item' : '' }}">
                            <div class="timeline__marker" aria-hidden="true"></div>
                            <div class="timeline__card timeline__card--media{{ $index === 0 ? ' timeline__card--raised' : '' }}">
                                <div class="timeline__body">
                                    <h3 class="timeline__title">{{ $project['title'] }}</h3>
                                    <p class="timeline__detail">{{ $project['description'] }}</p>

                                    @if(!empty($project['tech']))
                                        <ul class="tag-list" style="margin-top: .9rem;">
                                            @foreach($project['tech'] as $tech)
                                                <li class="tag">{{ $tech }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>

                                @if(!empty($project['image']))
                                    <div class="timeline__media">
                                        <a href="{{ $project['image'] }}" data-project-image="{{ $project['image'] }}" aria-label="View {{ $project['title'] }}">
                                            <img src="{{ $project['image'] }}" alt="{{ $project['title'] }}" loading="lazy">
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    </div>

                    <button type="button" class="btn btn--outline more-projects__toggle" aria-expanded="false">
                        See More Projects
                    </button>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== PROJECT MODAL ===== --}}
    <x-project-modal :projects="$projects" />

    {{-- ===== GALLERY MODAL ===== --}}
    <x-gallery-modal />

    {{-- ===== CERTIFICATE VIEWER ===== --}}
    <div class="gallery-overlay" id="certViewer" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="gallery-modal">
            <div class="gallery-modal__header">
                <span class="gallery-modal__counter" id="certViewerCounter"></span>
                <button class="gallery-modal__close" id="certViewerClose" aria-label="Close certificate">&times;</button>
            </div>
            <div class="gallery-modal__viewport">
                <img src="" alt="Certificate" class="gallery-modal__img" id="certViewerImg" />
                <button class="gallery-modal__arrow gallery-modal__arrow--prev" id="certViewerPrev" aria-label="Previous certificate">&#10094;</button>
                <button class="gallery-modal__arrow gallery-modal__arrow--next" id="certViewerNext" aria-label="Next certificate">&#10095;</button>
            </div>
        </div>
    </div>

    {{-- ===== PROJECT IMAGE VIEWER ===== --}}
    <div class="gallery-overlay" id="projectViewer" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="gallery-modal">
            <div class="gallery-modal__header">
                <span class="gallery-modal__counter" id="projectViewerCounter"></span>
                <button class="gallery-modal__close" id="projectViewerClose" aria-label="Close project image">&times;</button>
            </div>
            <div class="gallery-modal__viewport">
                <img src="" alt="Project" class="gallery-modal__img" id="projectViewerImg" />
                <button class="gallery-modal__arrow gallery-modal__arrow--prev" id="projectViewerPrev" aria-label="Previous project">&#10094;</button>
                <button class="gallery-modal__arrow gallery-modal__arrow--next" id="projectViewerNext" aria-label="Next project">&#10095;</button>
            </div>
        </div>
    </div>

    {{-- ===== EDUCATION ===== --}}
    <section id="education" class="section">
        <div class="container">
            <x-section-heading
                eyebrow="Education & Experience"
                icon="graduation"
                lead="The academic journey and experiences that shaped who I am today." />

            <div class="edu-panels">
                <div class="edu-panel">
                    <h3 class="edu-panel__title">Education</h3>
                    <div class="timeline">
                        @foreach($education as $index => $item)
                            <div class="timeline__item reveal">
                                <div class="timeline__marker" aria-hidden="true"></div>
                                <div class="timeline__card">
                                    <span class="timeline__type">{{ $item['type'] }}</span>
                                    <h3 class="timeline__title">{{ $item['program'] }}</h3>
                                    <p class="timeline__school">{{ $item['school'] }}</p>
                                    <span class="timeline__period">{{ $item['period'] }}</span>
                                    @if(!empty($item['detail']))
                                        <p class="timeline__detail">{{ $item['detail'] }}</p>
                                    @endif

                                    @if(!empty($item['highlights']))
                                        <ul class="timeline__hi">
                                            @foreach($item['highlights'] as $h)
                                                <li>{{ $h }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="edu-panel">
                    <h3 class="edu-panel__title">Experience</h3>
                    <div class="timeline">
                        @foreach($experience as $index => $item)
                            <div class="timeline__item reveal">
                                <div class="timeline__marker" aria-hidden="true"></div>
                                <div class="timeline__card">
                                    <span class="timeline__type">{{ $item['role'] }}</span>
                                    <h3 class="timeline__title">{{ $item['company'] }}</h3>
                                    <span class="timeline__period">{{ $item['period'] }}</span>
                                    @if(!empty($item['detail']))
                                        <p class="timeline__detail">{{ $item['detail'] }}</p>
                                    @endif

                                    @if(!empty($item['highlights']))
                                        <ul class="timeline__hi">
                                            @foreach($item['highlights'] as $h)
                                                <li>{{ $h }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== CERTIFICATIONS ===== --}}
    <section id="skills" class="section">
        <div class="container">
            <x-section-heading
                eyebrow="Certifications"
                icon="wrench"
                title="What I bring to the table"
                lead="A collection of certifications and training that reflect my continuous learning, developing skills, and commitment to personal and professional growth." />

            <div class="certs">
                <div class="certs-grid">
                    @foreach($certifications as $cert)
                        <article class="cert-card reveal">
                            @if(!empty($cert['image']))
                                <a class="cert-card__img-btn" href="{{ $cert['image'] }}" data-cert-image="{{ $cert['image'] }}" aria-label="View {{ $cert['title'] }}">
                                    <img class="cert-card__img" src="{{ $cert['image'] }}" alt="{{ $cert['title'] }} certificate" loading="lazy">
                                </a>
                            @elseif(!empty($cert['file']))
                                <iframe class="cert-card__pdf" src="{{ asset($cert['file']) }}" title="{{ $cert['title'] }}" loading="lazy"></iframe>
                            @else
                                <span class="cert-card__icon"><x-icons.icon name="award" /></span>
                            @endif
                            <h4 class="cert-card__title">{{ $cert['title'] }}</h4>
                            <p class="cert-card__issuer">{{ $cert['issuer'] }}</p>
                            <span class="cert-card__date">{{ $cert['date'] }}</span>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ===== CONTACT ===== --}}
    <section id="contact" class="section">
        <div class="container">
            <x-section-heading
                eyebrow="Contact"
                icon="send"
                title="Let's build something together"
                lead="Have a project in mind or just want to say hi? My inbox is always open." />

            <div class="contact__grid">
                <div class="contact__info">
                    <div class="contact__item">
                        <span class="contact__icon"><x-icons.social name="mail" /></span>
                        <div>
                            <span class="contact__label">Email</span>
                            <a class="contact__value" href="mailto:{{ $contacts['email'] }}">{{ $contacts['email'] }}</a>
                        </div>
                    </div>

                    <div class="contact__item">
                        <span class="contact__icon"><x-icons.social name="phone" /></span>
                        <div>
                            <span class="contact__label">Phone</span>
                            <a class="contact__value" href="tel:{{ str_replace([' ', '(', ')', '-'], '', $contacts['phone']) }}">{{ $contacts['phone'] }}</a>
                        </div>
                    </div>

                    <div class="contact__item">
                        <span class="contact__icon"><x-icons.social name="location" /></span>
                        <div>
                            <span class="contact__label">Location</span>
                            <span class="contact__value">{{ $profile['location'] }}</span>
                        </div>
                    </div>

                    </div>
            </div>
        </div>
    </section>

</x-layout>
