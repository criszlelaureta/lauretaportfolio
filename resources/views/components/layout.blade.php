@props([
    'title' => 'Portfolio',
    'profile' => null,
    'contacts' => null,
])

<!DOCTYPE html>
<html lang="en" data-theme="dark" data-accent="green">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Personal portfolio of {{ $profile['name'] ?? 'Renz Laureta' }} — computer engineering student, web developer, and problem solver.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <link rel="icon" type="image/png" href="{{ asset('img/nlogo-tab.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app.css?v=81') }}">

    <script>
        document.documentElement.setAttribute('data-theme', 'dark');
        document.documentElement.setAttribute('data-accent', 'green');
    </script>
</head>
<body>

    @include('components.partials.hero-background')

    <x-partials.nav :profile="$profile" />

    <main id="main" class="site-main">
        {{ $slot }}
    </main>

    <x-partials.footer :contacts="$contacts" :profile="$profile" />

    <script src="{{ asset('js/app.js?v=9') }}" defer></script>
</body>
</html>
