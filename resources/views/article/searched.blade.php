<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('ui.searchResultsFor') }} {{ $query }} - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <x-navbar />

    <div class="container py-4 py-lg-5">
        <div class="row justify-content-center text-center mb-4">
            <div class="col-12">
                <h1 class="display-6">{{ __('ui.searchResultsFor') }} <span class="fst-italic">{{ $query }}</span></h1>
            </div>
        </div>

        <div class="row g-4 mb-4">
            @forelse ($articles as $article)
                <div class="col-12 col-md-6 col-lg-3">
                    <x-card :article="$article" />
                </div>
            @empty
                <div class="col-12 text-center">
                    <h3>{{ __('ui.noSearchResults') }}</h3>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center">
            {{ $articles->links() }}
        </div>
    </div>
</body>
</html>
