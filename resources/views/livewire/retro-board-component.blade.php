<div x-data="{ timeRemaining: @entangle('timeRemaining') }" x-init="setInterval(() => { if (timeRemaining > 0) timeRemaining--; }, 1000)" class="container p-4 mx-auto">
    <!-- Header with title, timer, and Save Board button -->
    <div class="flex items-center justify-between mb-4">
        <flux:heading size="xl">Team Retrospective</flux:heading>
        <div class="text-lg">
            Time remaining:
            <livewire:timer></livewire:timer>
        </div>
        <flux:switch wire:change="toggleSave" label="Save Board" @if ($this->board->is_saved) checked @endif />


        @if (!$this->board->is_saved)
            <button wire:click="saveBoard" class="px-4 py-2 text-white bg-blue-500 rounded">
                Save Board
            </button>
        @else
            <flux:input icon="key" value="{{ $link_to_board }}" readonly copyable />
        @endif
    </div>

    <!-- Three columns for the swim lanes -->
    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <!-- What Went Well -->
        <flux:card class="space-y-6">
            <div>
                <flux:heading size="lg">What Went Well</flux:heading>
                <flux:subheading>Add items we did well.</flux:subheading>
            </div>
            <div>
                <flux:textarea rows="auto" wire:model.defer="newItemContent.went_well" />
                @error('newItemContent.went_well')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <flux:button wire:click="addItem('went_well')" variant="primary" class="w-full">Add Item</flux:button>
            <flux:separator />
            <ul>
                @foreach ($wentWellItems as $item)
                    <flux:context>
                        <li class="flex items-center justify-between mb-2">
                            <span>{{ $item->content }}</span>
                            <flux:badge class="ml-4" as="button" wire:click="voteItem({{ $item->id }})"
                                variant="pill" icon="hand-thumb-up" size="lg">
                                {{ $item->vote_count }}
                            </flux:badge>
                        </li>

                        <flux:menu>
                            <flux:menu.item variant="danger" icon="trash"
                                wire:click="removeItem({{ $item->id }})">Delete</flux:menu.item>
                        </flux:menu>

                    </flux:context>
                @endforeach
            </ul>
        </flux:card>

        <flux:card class="space-y-6">
            <div>
                <flux:heading size="lg">What could we improve</flux:heading>
                <flux:subheading>Add items we could improve upon.</flux:subheading>
            </div>
            <div>
                <flux:textarea rows="auto" wire:model.defer="newItemContent.could_improve" />
            </div>
            <flux:button wire:click="addItem('could_improve')" variant="primary" class="w-full">Add Item</flux:button>
            <flux:separator />
            <ul class="divide-y divide-gray-200 dark:divide-gray-500">
                @foreach ($couldImproveItems as $item)
                    <li key class="flex items-center justify-between p-2 mb-2">
                        <span>{{ $item->content }}</span>
                        <flux:badge class="ml-4" as="button" wire:click="voteItem({{ $item->id }})"
                            variant="pill" icon="hand-thumb-up" size="sm">
                            {{ $item->vote_count }}
                        </flux:badge>
                    </li>
                @endforeach
            </ul>
        </flux:card>

        <flux:card class="space-y-6">
            <div>
                <flux:heading size="lg">Action Items</flux:heading>
                <flux:subheading>Things we need to do based on discussions.</flux:subheading>
            </div>
            <div>
                <flux:textarea rows="auto" wire:model.defer="newItemContent.action_item" />
            </div>
            <flux:button wire:click="addItem('action_item')" variant="primary" class="w-full">Add Item</flux:button>
            <flux:separator />
            <ul>
                @foreach ($actionItemItems as $item)
                    <li class="flex items-center justify-between mb-2">
                        <span>{{ $item->content }}</span>
                        <flux:badge as="button" wire:click="voteItem({{ $item->id }})" variant="pill"
                            icon="hand-thumb-up" size="sm">
                            {{ $item->vote_count }}
                        </flux:badge>
                    </li>
                @endforeach
            </ul>
        </flux:card>
    </div>
</div>
