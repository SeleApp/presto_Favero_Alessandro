<?php

namespace App\Livewire;

use App\Jobs\GoogleVisionLabelImage;
use App\Jobs\GoogleVisionRemoveFaces;
use App\Jobs\GoogleVisionSafeSearch;
use App\Jobs\ResizeImage;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateArticleForm extends Component
{
    use WithFileUploads;

    public string $title = '';
    public string $description = '';
    public string $price = '';
    public string $category_id = '';
    public array $temporary_images = [];

    protected function rules(): array
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:10',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'temporary_images.*' => 'image|max:2048',
        ];
    }

    public function removeImage(int $key): void
    {
        unset($this->temporary_images[$key]);
        $this->temporary_images = array_values($this->temporary_images);
    }

    public function cleanForm(): void
    {
        $this->reset(['title', 'description', 'price', 'category_id']);
        $this->temporary_images = [];
    }

    public function store(): void
    {
        $validated = $this->validate();

        $article = Article::create([
            'user_id' => Auth::id(),
            'category_id' => (int) $validated['category_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'is_accepted' => null,
        ]);

        if (! empty($this->temporary_images)) {
            foreach ($this->temporary_images as $image) {
                $newImage = $article->images()->create([
                    'path' => $image->store('images', 'public'),
                ]);

                ResizeImage::withChain([
                    new GoogleVisionSafeSearch($newImage->id),
                    new GoogleVisionLabelImage($newImage->id),
                    new GoogleVisionRemoveFaces($newImage->id),
                ])->dispatch(300, 300, dirname($newImage->path), basename($newImage->path));
            }
        }

        $this->cleanForm();
        session()->flash('success', __('ui.articleCreated'));
    }

    public function render()
    {
        return view('livewire.create-article-form', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }
}
