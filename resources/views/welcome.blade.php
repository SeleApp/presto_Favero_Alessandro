<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <x-navbar />

    <div class="container py-4 py-lg-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">{{ __('ui.latestArticles') }}</h1>
            <a href="{{ route('article.index') }}" class="btn btn-outline-secondary">{{ __('ui.seeAll') }}</a>
        </div>

        <div class="row g-4">
            @forelse ($articles as $article)
                <div class="col-md-6 col-lg-4">
                    <x-card :article="$article" />
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info mb-0">{{ __('ui.noAvailableArticles') }}</div>
                </div>
            @endforelse
        </div>
    </div>
</body>
</html>
