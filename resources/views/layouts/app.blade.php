@extends('layouts.base')

@section('body')
    <livewire:components.top-menu-header />

     <!-- Text Header -->
     <header class="w-full container mx-auto">
        <div class="flex flex-col items-center py-12">
            <a class="font-bold text-gray-800 hover:text-gray-700 text-5xl" href="{{ url('/') }}" wire:navigate>
                GPdI Imanuel Rerer 1
            </a>
            <p class="text-lg text-gray-600">
                Wilayah 51 Kombi, Minahasa, Sulawesi Utara - Indonesia
            </p>
        </div>
    </header>

    <livewire:components.topic-menu />

    <div class="container mx-auto flex flex-wrap py-6">

        <!-- Posts Section -->
        <section class="w-full md:w-2/3 flex flex-col items-center px-3">

            @isset($slot)
                {{ $slot }}
            @endisset

        </section>

        <!-- Sidebar Section -->
        <aside class="w-full md:w-1/3 flex flex-col items-center px-3">

            <livewire:components.side-content />
        </aside>
    </div>

    <footer class="w-full border-t bg-white pb-12">
        <div class="w-full container mx-auto flex flex-col items-center">
            <div class="flex flex-col md:flex-row text-center md:text-left md:justify-between py-6">
                <a href="#" class="uppercase px-3">About Us</a>
                <a href="#" class="uppercase px-3">Privacy Policy</a>
                <a href="#" class="uppercase px-3">Terms & Conditions</a>
                <a href="#" class="uppercase px-3">Contact Us</a>
            </div>
            <div class="uppercase pb-6">&copy; imanuelrerer.org</div>
        </div>
    </footer>
@endsection
