<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="night">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    {{-- Load Tailwind CSS and your JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="">
    <header>
        <div class="navbar bg-base-100 shadow-sm">
            <div class="navbar-start">
                <div class="dropdown">
                    <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /> </svg>
                    </div>
                    <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                        <li><a href="{{ route('home') }}" wire:navigate>Home</a></li>
                        <li>
                            <span>Water</span>
                            <ul class="p-2">
                                <li><a href="{{ route('water.hydrogen') }}" wire:navigate>Hydrogen</a></li>
                                <li><a href="{{ route('water.oxygen') }}" wire:navigate>Oxygen</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <a class="btn btn-ghost text-xl">daisyUI</a>
            </div>
            <div class="navbar-center hidden lg:flex">
                <ul class="menu menu-horizontal px-1">
                    <li><a>Item 1</a></li>
                    <li>
                        <details>
                            <summary>Parent</summary>
                            <ul class="p-2">
                                <li><a>Submenu 1</a></li>
                                <li><a>Submenu 2</a></li>
                            </ul>
                        </details>
                    </li>
                    <li><a>Item 3</a></li>
                </ul>
            </div>
            <div class="navbar-end">
                @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">

                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="m-1">
                            {{-- dark Mode SVG --}}
                            <svg id="darkFace" class="theme-face" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 100 100" style="border-radius: 50%; display: block;">
                                <circle cx="50" cy="50" r="48" style="stroke:#444; stroke-width:4; fill:#222;" />
                                <circle cx="50" cy="35" r="12" style="fill:#555;" />
                                <path d="M30,75 Q50,55 70,75" style="fill:#555;" />
                            </svg>
                        </div>

                        <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm">
                            @auth
                            <li>
                                <a href="{{ url('/dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            @else
                            <li>
                                <a href="{{ route('login') }}">
                                    Log in
                                </a>
                            </li>
                            @if (Route::has('register'))
                            <li>
                                <a href="{{ route('register') }}">
                                    Register
                                </a>
                            </li>
                            @endif
                            @endauth
                        </ul>
                    </div>

                </nav>
                @endif
            </div>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer>
        <div class="footer footer-center p-4 bg-base-200 text-base-content">
            <div>
                <p>Copyright © 2025 - All right reserved by <a href="https://example.com">Your Company</a></p>
            </div>
        </div>
    </footer>
</body>
</html>
