<div class="p-4">
    <button wire:click="refreshRoutes" class="btn btn-sm btn-success mb-2">🔄 Refresh Routes</button>        
<br>
    <ul class="menu menu-xs bg-base-200 rounded-box max-w-xs w-full">
        @foreach ($routes as $node)
            @include('livewire.templebuilder.route-node', ['node' => $node])
        @endforeach
    </ul>
</div>
