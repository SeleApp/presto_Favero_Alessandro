<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateArticleForm extends Component
{
    public string $title = '';
    public string $description = '';
    public string $price = '';
    public string $category_id = '';

    protected function rules(): array
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:10',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();

        Article::create([
            'user_id' => Auth::id(),
            'category_id' => (int) $validated['category_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'is_accepted' => null,
        ]);

        $this->reset(['title', 'description', 'price', 'category_id']);
        session()->flash('success', 'Annuncio creato correttamente.');
    }

    public function render()
    {
        return view('livewire.create-article-form', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }
}
