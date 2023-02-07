<?php

test('homepage contains livewire component', function () {
    $this->get('/social/home')->assertSeeLivewire('social::home');
});

test('homepage load successfully', function () {
    $this->get('/social/home')->assertStatus(200);
});
