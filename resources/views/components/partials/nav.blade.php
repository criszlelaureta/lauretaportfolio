@props(['profile' => null])

<header class="site-header">
    <nav class="nav container" aria-label="Primary">

        <a href="#home" class="nav__brand" aria-label="{{ $profile['name'] ?? 'Renz Laureta' }}">
            <span class="nav__brand-mark">
                <img src="{{ asset('img/nlogo.png') }}" alt="" class="nav__brand-logo" />
            </span>
        </a>

        <ul class="nav__links" id="navLinks">
            <li><a class="nav__link" data-navlink href="#home">Home</a></li>
            <li><a class="nav__link" data-navlink href="#about">About</a></li>
            <li><a class="nav__link" data-navlink href="#education">Education & Experience</a></li>
            <li><a class="nav__link" data-navlink href="#skills">Certificates</a></li>
            <li><a class="nav__link" data-navlink href="#projects">Projects</a></li>
            <li><a class="nav__link" data-navlink href="#contact">Contact</a></li>
        </ul>

        <div class="nav__tools">
            <button
                type="button"
                class="icon-btn nav__hamburger"
                id="navToggle"
                aria-label="Toggle navigation menu"
                aria-expanded="false"
                aria-controls="navLinks">
                <span class="hamburger-bar"></span>
                <span class="hamburger-bar"></span>
                <span class="hamburger-bar"></span>
            </button>
        </div>
    </nav>
</header>
