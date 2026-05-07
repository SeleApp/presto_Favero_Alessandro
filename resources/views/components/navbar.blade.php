<nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('homepage') }}">Presto.it</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('homepage') }}">{{ __('ui.home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('article.index') }}">{{ __('ui.allArticles') }}</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ __('ui.categories') }}
                    </a>
                    <ul class="dropdown-menu">
                        @forelse ($categories as $category)
                            <li>
                                <a class="dropdown-item" href="{{ route('byCategory', ['category' => $category]) }}">{{ __('ui.' . $category->name) }}</a>
                            </li>
                        @empty
                            <li><span class="dropdown-item-text text-muted">{{ __('ui.noCategories') }}</span></li>
                        @endforelse
                    </ul>
                </li>
                @auth
                    @if (Auth::user()->is_revisor)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('revisor.index') }}">
                                {{ __('ui.revisorArea') }}
                                <span class="badge rounded-pill text-bg-warning">
                                    {{ \App\Models\Article::where('is_accepted', null)->count() }}
                                </span>
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            <div class="d-flex gap-2 align-items-center">
                <x-language-flag lang="it" icon="it" />
                <x-language-flag lang="uk" icon="gb" />
                <x-language-flag lang="es" icon="es" />

                <a href="{{ route('articles.create') }}" class="btn btn-sm btn-primary">{{ __('ui.newArticle') }}</a>
                @if (Route::has('login'))
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-dark">{{ __('ui.logout') }}</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-secondary">{{ __('ui.login') }}</a>
                    @endauth
                @endif
            </div>
        </div>
    </div>
</nav>
