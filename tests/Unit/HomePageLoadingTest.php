<?php

test('homepage-loading', function () {
    \Pest\Laravel\get('/home/social')->assertSeeLivewire(\Modules\Social\Http\Livewire\Home::class);
});
