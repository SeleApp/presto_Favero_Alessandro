<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('ui.revisorArea') }} - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <x-navbar />

    <div class="container py-4 py-lg-5">
        <h1 class="h3 mb-4">{{ __('ui.revisorArea') }}</h1>

        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        @if ($article_to_check)
            <div class="card shadow-sm">
                <img src="{{ $article_to_check->image ?? 'https://picsum.photos/seed/' . $article_to_check->id . '/1200/500' }}" class="card-img-top" alt="{{ $article_to_check->title }}">
                <div class="card-body">
                    <h2 class="h4">{{ $article_to_check->title }}</h2>
                    <p class="text-muted mb-2">
                        {{ __('ui.category') }}:
                        <a href="{{ route('byCategory', ['category' => $article_to_check->category]) }}">{{ $article_to_check->category ? __('ui.' . $article_to_check->category->name) : __('ui.na') }}</a>
                    </p>
                    <p class="h5 mb-3">{{ number_format($article_to_check->price, 2, ',', '.') }} EUR</p>
                    <p class="mb-4">{{ $article_to_check->description }}</p>

                    <div class="d-flex gap-2">
                        <form action="{{ route('revisor.accept', ['article' => $article_to_check]) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success">{{ __('ui.accept') }}</button>
                        </form>

                        <form action="{{ route('revisor.reject', ['article' => $article_to_check]) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-danger">{{ __('ui.reject') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info mb-0">{{ __('ui.noArticlesToReview') }}</div>
        @endif
    </div>
</body>
</html>
