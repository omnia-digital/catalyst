@php use Filament\Support\Facades\FilamentView; @endphp
<div class="fi-global-search flex items-center">
    {{ FilamentView::renderHook('panels::global-search.start') }}

    <div class="relative">
        <x-filament-panels::global-search.field/>

        @if ($results !== null)
            <x-filament-panels::global-search.results-container
                    :results="$results"
            />
        @endif
    </div>

    {{ FilamentView::renderHook('panels::global-search.end') }}
</div>
