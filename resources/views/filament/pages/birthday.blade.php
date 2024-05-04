<x-filament-panels::page>
    <form wire:submit="submit">
        <x-filament::section heading="Date Range Filter" collapsible collapsed>
            {{ $this->form }}
            <div class="text-right mt-6">
                <x-filament::button color="primary" type="submit" class="fi-btn btn-primary">
                    Apply Filter
                </x-filament::button>
            </div>
        </x-filament::section>
    </form>

    <x-filament::section :heading="'Members Birthday' . (!$isCustom ? ' This Week' : '')">

        @foreach($memberByDay as $key => $date)
            <div>
                <strong>{{ $date["title"] }}</strong>
                <ul class="ml-3">
                    @foreach($date["data"] as $member)
                    <li>
                        <a href="{{ $member->url }}">
                            &nbsp; > {{ $member->front_title }} {{ $member->name }}
                            (<strong>{{ $member->ageOnDate }}</strong> thn)
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <br />
        @endforeach
    </x-filament::section>
</x-filament-panels::page>
