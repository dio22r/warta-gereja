<?php

namespace App\Livewire\Components;

use Livewire\Attributes\Computed;
use Livewire\Component;

class BlogItemCard extends Component
{
    public $post = null;

    #[Computed]
    public function itemUrl()
    {
        return route("post.show", ["slug" => $this->post->slug]);
    }

    public function render()
    {
        return view('livewire.components.blog-item-card');
    }
}
