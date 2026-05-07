<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crea Annuncio - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">Crea un nuovo annuncio</h1>
                    <a href="{{ route('homepage') }}" class="btn btn-outline-secondary">Torna alla home</a>
                </div>
                <livewire:create-article-form />
            </div>
        </div>
    </div>

    @livewireScripts
</body>
</html>
