@props(['name' => ''])

@php
    $stroke = 'viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"';
@endphp

@switch($name)
    @case('code')
        <svg {!! $stroke !!} aria-hidden="true">
            <path d="m16 18 6-6-6-6M8 6l-6 6 6 6"/>
        </svg>
        @break

    @case('user')
        <svg {!! $stroke !!} aria-hidden="true">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
        </svg>
        @break

    @case('layers')
        <svg {!! $stroke !!} aria-hidden="true">
            <path d="m12 2 10 6-10 6L2 8l10-6z"/>
            <path d="m2 12 10 6 10-6"/>
        </svg>
        @break

    @case('wrench')
        <svg {!! $stroke !!} aria-hidden="true">
            <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
        </svg>
        @break

    @case('users')
        <svg {!! $stroke !!} aria-hidden="true">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
        </svg>
        @break

    @case('graduation')
        <svg {!! $stroke !!} aria-hidden="true">
            <path d="M22 10 12 5 2 10l10 5 10-5z"/>
            <path d="M6 12v5c0 1.7 2.7 3 6 3s6-1.3 6-3v-5"/>
            <path d="M22 10v6"/>
        </svg>
        @break

    @case('briefcase')
        <svg {!! $stroke !!} aria-hidden="true">
            <rect x="2" y="7" width="20" height="14" rx="2"/>
            <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>
        </svg>
        @break

    @case('award')
        <svg {!! $stroke !!} aria-hidden="true">
            <circle cx="12" cy="8" r="6"/>
            <path d="M15.48 12.78 17 22l-5-3-5 3 1.52-9.22"/>
        </svg>
        @break

    @case('folder')
        <svg {!! $stroke !!} aria-hidden="true">
            <path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7z"/>
        </svg>
        @break

    @case('send')
        <svg {!! $stroke !!} aria-hidden="true">
            <path d="m22 2-7 20-4-9-9-4 20-7z"/>
            <path d="M22 2 11 13"/>
        </svg>
        @break

    @case('arrow-up')
        <svg {!! $stroke !!} aria-hidden="true">
            <path d="M12 19V5M5 12l7-7 7 7"/>
        </svg>
        @break

    @case('external')
        <svg {!! $stroke !!} aria-hidden="true">
            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
            <path d="M15 3h6v6M10 14 21 3"/>
        </svg>
        @break

    @case('download')
        <svg {!! $stroke !!} aria-hidden="true">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
            <polyline points="7 10 12 15 17 10"/>
            <line x1="12" y1="15" x2="12" y2="3"/>
        </svg>
        @break

    @default
        <svg {!! $stroke !!} aria-hidden="true">
            <circle cx="12" cy="12" r="10"/>
        </svg>
@endswitch
