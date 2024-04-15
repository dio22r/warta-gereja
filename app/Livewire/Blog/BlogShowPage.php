<?php

namespace App\Livewire\Blog;

use App\Models\Post;
use Illuminate\Http\Request;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout("layouts.app")]
class BlogShowPage extends Component
{
    public ?Object $post = null;

    #[Computed]
    public function itemUrl()
    {
        return route("post.show", ["slug" => $this->post->slug]);
    }

    public function mount(Request $request, $slug)
    {
        $this->post = Post::query()
            ->where("slug", $slug)
            ->first();
    }

    public function render()
    {
        return view('livewire.blog.blog-show-page');
    }
}
