<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;

class Timer extends Component
{
    public Carbon $endTime;
    public $timer;

    public function mount()
    {
        $this->endTime = now()->addMinutes(10);

        $this->setTimeRemaining();
    }

    public function setTimeRemaining()
    {
        $this->timer = $this->endTime->diffInSeconds();
    }

    public function render()
    {
        return <<<'HTML'
        <div x-data="{ timer: @entangle('timer') }" x-init="setInterval(() => { if (timer > 0) timer--; }, 1000)">
            <p x-text="Math.floor(timeRemaining / 60) + ':' + ((timeRemaining % 60) < 10 ? '0' : '') + (timeRemaining % 60)"></p>
        </div>
        HTML;
    }
}
