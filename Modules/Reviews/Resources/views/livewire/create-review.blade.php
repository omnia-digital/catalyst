<div>
    {{ $this->form }}
    <x-library::button 
        class="mt-8 hover:bg-neutral-dark" 
        wire:click.prevent="createReview"
    >{{ \Trans::get('Create Review') }}</x-library::button>
</div>
