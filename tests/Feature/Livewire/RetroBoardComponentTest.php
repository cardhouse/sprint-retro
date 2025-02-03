<?php

use App\Livewire\RetroBoardComponent;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(RetroBoardComponent::class)
        ->assertStatus(200);
});
