<?php

namespace App\Livewire\Blog;

use App\Models\Post;
use Illuminate\Http\Request;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout("layouts.app")]
class BlogListPage extends Component
{

    public function mount(Request $request): void
    {
        $request->validate([]);
    }

    public function render()
    {
        return view('livewire.blog.blog-list-page', [
            'posts' => Post::query()
                ->paginate(10)
        ]);
    }
}
