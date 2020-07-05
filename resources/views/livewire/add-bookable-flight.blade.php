<div>
    <form wire:submit.prevent="save">
        <div>
            <input wire:model.lazy="callsign" class="input w-full" type="text" placeholder="Callsign" required>
            @error('callsign')
                <div class="text-red-800">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mt-4 -mx-2 flex">
            <div class="px-2 w-1/2">
                <input wire:model.lazy="originAirportIcao" class="input w-full" type="text" placeholder="From Airport ICAO" required>
            </div>
            <div class="px-2 w-1/2">
                <input wire:model.lazy="destinationAirportIcao" class="input w-full" type="text" placeholder="To Airport ICAO" required>
            </div>
        </div>
        @error('originAirportIcao')
            <div class="text-red-800">
                {{ $message }}
            </div>
        @enderror
        @error('destinationAirportIcao')
            <div class="text-red-800">
                {{ $message }}
            </div>
        @enderror
        <div class="mt-4 -mx-2 flex">
            <div class="px-2 w-1/2">
                <input wire:model.lazy="departureDate" class="input w-full" type="date" placeholder="Departure date" required>
            </div>
            <div class="px-2 w-1/2">
                <input wire:model.lazy="departureTime" class="input w-full" type="time" placeholder="Departure time" required>
            </div>
        </div>
        @error('departureDate')
            <div class="text-red-800">
                {{ $message }}
            </div>
        @enderror
        @error('departureTime')
            <div class="text-red-800">
                {{ $message }}
            </div>
        @enderror
        <div class="mt-4 -mx-2 flex">
            <div class="px-2 w-1/2">
                <input wire:model.lazy="arrivalDate" class="input w-full" type="date" placeholder="Arrival date" required>
            </div>
            <div class="px-2 w-1/2">
                <input wire:model.lazy="arrivalTime" class="input w-full" type="time" placeholder="Arrival time" required>
            </div>
        </div>
        @error('arrivalDate')
            <div class="text-red-800">
                {{ $message }}
            </div>
        @enderror
        @error('arrivalTime')
            <div class="text-red-800">
                {{ $message }}
            </div>
        @enderror
        @if ($added)
            <div class="mt-2 p-2 text-blue-300 bg-blue-50 border-2 border-blue-500">
                Flight was added!
            </div>
        @endif
        <div class="mt-4">
            <button type="submit" class="input w-full btn btn-blue">Add flight</button>
        </div>
    </form>
</div>
