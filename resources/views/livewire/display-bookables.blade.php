<div>
    @forelse($bookables as $bookable)
        @if($bookable->type == 'flight')
            <div class="-mx-1 flex font-light rounded bg-gray-100 mt-4 px-2 py-3">
                <div class="px-1 w-3/4">
                    <span class="font-semibold">{{ $bookable->data['callsign'] }}</span> departing
                    <span class="font-semibold">
                        {{ $bookable->begin_date->format('Y-m-d') }}
                        {{ $bookable->begin_time->format('H:i') }}z
                    </span>
                    @isset($bookable->data['origin_airport_icao'])
                        from
                        <span class="font-semibold">
                            {{ $bookable->data['origin_airport_icao'] }}
                        </span>
                    @endisset
                    @isset($bookable->data['destination_airport_icao'])
                        arriving at
                        <span class="font-semibold">
                            {{ $bookable->data['destination_airport_icao'] }}
                        </span>
                        (approx.
                        {{ $bookable->end_date->format('Y-m-d') }}
                        {{ $bookable->end_time->format('H:i') }}z)
                    @endisset
                </div>
                <div class="px-1 w-1/4 flex justify-center items-center">
                    <button wire:click="deleteBookable({{$bookable->id}})" class="btn-sm btn-red-secondary">Delete</button>
                </div>
            </div>
        @endif
    @empty
        No bookables added yet...
    @endforelse
</div>
