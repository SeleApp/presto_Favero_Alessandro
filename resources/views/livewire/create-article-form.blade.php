<div class="card shadow-sm">
    <div class="card-body p-4">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit="save" class="row g-3">
            <div class="col-12">
                <label for="title" class="form-label">{{ __('ui.title') }}</label>
                <input wire:model="title" type="text" id="title" class="form-control @error('title') is-invalid @enderror" />
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="description" class="form-label">{{ __('ui.description') }}</label>
                <textarea wire:model="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror"></textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="price" class="form-label">{{ __('ui.price') }}</label>
                <input wire:model="price" type="number" step="0.01" min="0" id="price" class="form-control @error('price') is-invalid @enderror" />
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="category" class="form-label">{{ __('ui.category') }}</label>
                <select wire:model="category_id" id="category" class="form-select @error('category_id') is-invalid @enderror">
                    <option value="">{{ __('ui.selectCategory') }}</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ __('ui.' . $category->name) }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 d-grid">
                <button class="btn btn-primary" type="submit">{{ __('ui.publishArticle') }}</button>
            </div>
        </form>
    </div>
</div>
