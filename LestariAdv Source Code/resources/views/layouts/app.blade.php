<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Lestari Adv' }}</title>

    {{-- CSP: FIX Midtrans Snap --}}
    <meta http-equiv="Content-Security-Policy"
        content="
default-src 'self';
style-src 'self' 'unsafe-inline' https://*.ngrok-free.app;
script-src 'self' 'unsafe-inline' 'unsafe-eval'
    https://*.ngrok-free.app
    https://app.sandbox.midtrans.com
    https://app.midtrans.com;
img-src 'self' data: https://*.ngrok-free.app;
frame-src https://app.sandbox.midtrans.com https://app.midtrans.com;
connect-src 'self' https://app.sandbox.midtrans.com https://app.midtrans.com;
">

    @livewireStyles
    @vite('resources/css/app.css')
</head>

<body>
    @livewire('partial.navbar')
    @include('pages.nontifikasi.notif')

    @yield('content')

    @livewire('partial.footer')
    @livewireScripts

    {{-- MIDTRANS SNAP (WAJIB) --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>

    {{-- APP JS TERAKHIR --}}
    @vite('resources/js/app.js')
</body>

</html>
