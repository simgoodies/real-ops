<div>
    @forelse($bookables as $bookable)
        {{ $bookable->data['callsign'] }}
        <button wire:click="deleteBookable({{$bookable->id}})">Delete</button>
    @empty
        No bookables added yet...
    @endforelse
</div>
