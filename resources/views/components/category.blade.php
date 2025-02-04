<flux:card class="space-y-6">
    <div>
        <flux:heading size="lg">{{ $title }}</flux:heading>
        <flux:subheading>{{ $subtitle }}</flux:subheading>
    </div>
    <div>
        <flux:textarea rows="auto" wire:model.defer="newItemContent.{{ $category }}" />
    </div>
    <flux:button wire:click="addItem({{ $category }})" variant="primary" class="w-full">Add Item</flux:button>
    <flux:separator />
    <ul class="divide-y divide-gray-200 dark:divide-gray-500">
        @foreach ($items as $item)
            <li class="flex items-center justify-between p-2 mb-2">
                <span>{{ $item->content }}</span>
                <flux:badge class="ml-4" as="button" wire:click="voteItem({{ $item->id }})" variant="pill"
                    icon="hand-thumb-up" size="sm">
                    {{ $item->vote_count }}
                </flux:badge>
            </li>
        @endforeach
    </ul>
</flux:card>
