<?php

namespace App\Livewire;

use App\Events\RetroItemAdded;
use App\Events\RetroItemDeleted;
use App\Events\RetroItemVoted;
use App\Models\RetroBoard;
use Livewire\Component;

class RetroBoardComponent extends Component
{
    public $boardToken;

    public $board;

    public $newItemContent = [
        'went_well' => '',
        'could_improve' => '',
        'action_item' => '',
    ];

    public $timeRemaining = 600;

    // protected $listeners = [
    //     'retroItemAdded' => 'refreshBoard',
    //     'retroItemVoted' => 'refreshBoard',
    // ];

    public function getListeners()
    {
        return [
            "echo:retro-board.{$this->boardToken},RetroItemAdded" => 'refreshBoard',
            "echo:retro-board.{$this->boardToken},RetroItemVoted" => 'refreshBoard',
        ];
    }

    public function mount($token)
    {
        $this->boardToken = $token;
        $this->board = RetroBoard::with('items')->where('token', $token)->firstOrFail();
    }

    public function addItem($category)
    {
        $this->validate([
            'newItemContent.'.$category => 'required',
        ]);

        $this->board->items()->create([
            'retro_board_id' => $this->board->id,
            'category' => $category,
            'content' => $this->newItemContent[$category],
        ]);

        $this->newItemContent[$category] = '';

        broadcast(new RetroItemAdded($this->boardToken))->toOthers();
        $this->refreshBoard();
    }

    public function voteItem($itemId)
    {
        $item = $this->board->items->find($itemId);
        $item->increment('vote_count');

        broadcast(new RetroItemVoted($this->boardToken))->toOthers();
        $this->refreshBoard();
    }

    public function removeItem($itemId)
    {
        $this->board->items()->find($itemId)->delete();

        broadcast(new RetroItemDeleted($this->boardToken))->toOthers();
        $this->refreshBoard();
    }

    public function saveBoard()
    {
        $this->board->update(['is_saved' => true]);
    }

    public function refreshBoard()
    {
        $this->board->refresh();
    }

    public function render()
    {
        return view('livewire.retro-board-component', [
            'wentWellItems' => $this->board->items->where('category', 'went_well')->sortByDesc('vote_count'),
            'couldImproveItems' => $this->board->items->where('category', 'could_improve')->sortByDesc('vote_count'),
            'actionItemItems' => $this->board->items->where('category', 'action_item')->sortByDesc('vote_count'),
        ]);
    }
}
