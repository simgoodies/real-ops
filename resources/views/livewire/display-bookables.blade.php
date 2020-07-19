<div>
    @forelse($bookables as $bookable)
        @if($bookable->type == 'flight')
            <div x-data="{showConfirm: false}">
                <div class="-mx-1 flex font-light rounded bg-gray-100 mt-4 px-2 py-3">
                    <div class="px-1 w-auto lg:w-3/4">
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
                    @if (!$bookable->isBooked())
                        <div x-show="!showConfirm" class="px-1 w-1/4 flex justify-center items-center">
                            <button @click="showConfirm = true" class="btn-sm btn-blue-secondary">Book this!</button>
                        </div>
                    @else
                        <div class="px-1 w-1/4 flex justify-center items-center">
                            <span class="py-2 px-1 rounded-tl-lg rounded-br-lg bg-blue-200">BOOKED!</span>
                        </div>
                    @endif
                </div>
                @if (!$bookable->isBooked())
                    <div x-show="showConfirm" @click.away="showConfirm = false" class="-mx-1 flex font-light rounded bg-blue-100 mt-4 mb-12 py-2">
                        <div class="px-1 w-3/4">
                            <input wire:model.lazy="email" class="input w-full" type="email" placeholder="Enter your e-mail" required>
                        </div>
                        <div class="px-1 w-1/4 flex justify-center items-center">
                            <button wire:click="bookBookable({{ $bookable->id }})" class="btn-sm btn-blue w-full" type="submit">Confirm!</button>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    @empty
        No bookables added yet...
    @endforelse
</div>
