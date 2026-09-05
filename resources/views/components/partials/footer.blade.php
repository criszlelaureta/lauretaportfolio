@props(['contacts' => null, 'profile' => null])

<footer class="site-footer">
    <div class="container footer__grid">

        <div class="footer__brand">
            <a href="#home" class="footer__logo" aria-label="Criszle Laureta">
                <img src="{{ asset('img/nlogo.png') }}" alt="Criszle Laureta" class="footer__logo-img" />
            </a>
            <p class="footer__name">{{ $profile['name'] ?? 'Criszle T. Laureta' }}<span class="footer__dot">.</span> <span class="footer__location">{{ $profile['location'] ?? '' }}</span></p>
        </div>

        @if($contacts && isset($contacts['links']))
            <ul class="social-links footer__socials">
                @foreach($contacts['links'] as $link)
                    <li>
                        <a class="social-link social-link--lg" href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $link['label'] }}">
                            <x-icons.social :name="$link['icon']" />
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="footer__bottom">
        <p>&copy; {{ date('Y') }} {{ $contacts['full_name'] ?? 'Renz M. Laureta' }}. All rights reserved.</p>
    </div>

    <button type="button" class="back-to-top" id="backToTop" aria-label="Back to top">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 19V5"/><path d="M5 12l7-7 7 7"/></svg>
    </button>
</footer>
