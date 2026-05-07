<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $article->title }} - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <x-navbar />

    <div class="container py-4 py-lg-5">
        <div class="row g-4">
            <div class="col-lg-7">
                <div id="articleCarousel" class="carousel slide rounded overflow-hidden shadow-sm">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="https://picsum.photos/seed/{{ $article->id }}-1/900/500" class="d-block w-100" alt="Immagine annuncio 1">
                        </div>
                        <div class="carousel-item">
                            <img src="https://picsum.photos/seed/{{ $article->id }}-2/900/500" class="d-block w-100" alt="Immagine annuncio 2">
                        </div>
                        <div class="carousel-item">
                            <img src="https://picsum.photos/seed/{{ $article->id }}-3/900/500" class="d-block w-100" alt="Immagine annuncio 3">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#articleCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#articleCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h1 class="h3">{{ $article->title }}</h1>
                        <p class="text-muted mb-2">
                            Categoria:
                            <a href="{{ route('byCategory', ['category' => $article->category]) }}">{{ $article->category?->name ?? 'N/A' }}</a>
                        </p>
                        <p class="h4 mb-3">{{ number_format($article->price, 2, ',', '.') }} EUR</p>
                        <p class="mb-4">{{ $article->description }}</p>
                        <a href="{{ route('article.index') }}" class="btn btn-outline-secondary">Torna agli annunci</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
