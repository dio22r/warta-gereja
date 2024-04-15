
<div>

@foreach($posts->items() as $post)
    <livewire:components.blog-item-card :$post />
@endforeach

{{ $posts->links() }}
</div>
