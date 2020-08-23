<div>
    @forelse($bookables as $bookable)
        @if($event->bookable_type == 'flight' && $bookable->type == 'flight')
            <div wire:key="{{$bookable->id}}" class="-mx-1 flex font-light rounded bg-gray-100 mt-4 px-2 py-3">
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
                <div x-data="{showConfirm: false}" class="px-1 w-1/4 flex justify-center items-center">
                    <button x-show="!showConfirm" @click="showConfirm = true" class="btn-sm btn-red-secondary">Delete</button>
                    <button x-show="showConfirm" @click.away="showConfirm = false" wire:click="deleteBookable({{$bookable->id}})" class="btn-sm btn-red">Confirm?</button>
                </div>
            </div>
        @elseif($event->bookable_type == 'time-slot' && $bookable->type == 'time-slot')
            <div wire:key="{{$bookable->id}}" class="-mx-1 flex font-light rounded bg-gray-100 mt-4 px-2 py-3">
                <div class="px-1 w-3/4">
                    Time slot on <span class="font-semibold">{{ $bookable->begin_date->format('Y-m-d') }}</span> from
                    <span class="font-semibold">{{ $bookable->begin_time->format('H:i') }}z</span> to
                    <span class="font-semibold">{{ $bookable->end_time->format('H:i') }}z</span>
                    @if($bookable->end_date->gt($bookable->begin_date))
                        (overnight)
                    @endif
                    with <span class="font-semibold">{{ $bookable->available_bookables }} bookables</span>
                    @switch($bookable->data['direction'])
                        @case(\App\Models\BookableTimeSlot::DIRECTION_ANY)
                        in <span class="font-semibold">any</span> direction
                            @break
                        @case(\App\Models\BookableTimeSlot::DIRECTION_OUTBOUND)
                        for the <span class="font-semibold">outbound</span> direction
                            @break
                        @case(\App\Models\BookableTimeSlot::DIRECTION_INBOUND)
                        for the <span class="font-semibold">inbound</span> direction
                            @break
                    @endswitch
                    @isset($bookable->data['assignation'])
                        assigned to <span class="font-semibold">{{ $bookable->data['assignation'] }}</span>
                    @endisset
                </div>
                <div x-data="{showConfirm: false}" class="px-1 w-1/4 flex justify-center items-center">
                    <button x-show="!showConfirm" @click="showConfirm = true" class="btn-sm btn-red-secondary">Delete</button>
                    <button x-show="showConfirm" @click.away="showConfirm = false" wire:click="deleteBookable({{$bookable->id}})" class="btn-sm btn-red">Confirm?</button>
                </div>
            </div>
        @endif
    @empty
        No bookables added yet...
    @endforelse
</div>
