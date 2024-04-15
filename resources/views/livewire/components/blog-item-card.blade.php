
<article class="flex flex-col shadow my-4">
    <!-- Article Image -->
    <a href="{{ $this->itemUrl }}" class="hover:opacity-75">
        <img style="width:100%" src="{{ $post->cover_full_url }}" alt="{{ $post->title }}">
    </a>
    <div class="bg-white flex flex-col justify-start p-6">
        <a href="{{ $this->itemUrl }}"
            class="text-blue-700 text-sm font-bold uppercase pb-4">
            Technology
        </a>
        <a href="{{ $this->itemUrl }}"
            wire:navigate
            class="text-3xl font-bold hover:text-gray-700 pb-4">
            {{ $post->title }}
        </a>
        <p href="{{ $this->itemUrl }}"
            wire:navigate
            class="text-sm pb-3">
            By
            <a href="#"
                wire:navigate
                class="font-semibold hover:text-gray-800">
                David Grzyb
            </a>,
            Published on {{ $post->published_at->format("F j, Y") }}
        </p>
        <a href="{{ $this->itemUrl }}" wire:navigate class="pb-6">
            {{ $post->content_short }}
        </a>
        <a href="{{ $this->itemUrl }}" wire:navigate class="uppercase text-gray-800 hover:text-black">
            Continue Reading <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</article>
