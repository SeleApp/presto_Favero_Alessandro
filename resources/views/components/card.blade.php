<div class="card h-100 shadow-sm">
    <img src="{{ $article->images->isNotEmpty() ? Storage::url($article->images->first()->path) : 'https://picsum.photos/seed/' . $article->id . '/600/400' }}" class="card-img-top" alt="{{ $article->title }}">
    <div class="card-body d-flex flex-column">
        <h5 class="card-title">{{ $article->title }}</h5>
        <p class="card-text text-muted small mb-2">
            {{ __('ui.category') }}:
            <a href="{{ route('byCategory', ['category' => $article->category]) }}">{{ $article->category ? __('ui.' . $article->category->name) : __('ui.na') }}</a>
        </p>
        <p class="fw-semibold mb-3">{{ number_format($article->price, 2, ',', '.') }} EUR</p>
        <a href="{{ route('article.show', compact('article')) }}" class="btn btn-outline-primary mt-auto">{{ __('ui.details') }}</a>
    </div>
</div>
