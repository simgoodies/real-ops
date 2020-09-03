<div x-data="{ openBookableAction: 'none'}">
    <div class="flex">
        <div x-show="openBookableAction === 'none'" class="mt-4 px-4 md:px-4 w-1/2">
            <button class="btn btn-blue w-full" @click="openBookableAction = 'addFlight'">Add flight</button>
        </div>
        <div x-show="openBookableAction === 'none'" class="mt-4 px-4 md:px-4 w-1/2">
            <button class="btn btn-blue-secondary w-full" @click="openBookableAction = 'importFlights'">Import Flights</button>
        </div>
    </div>
    <div x-show="openBookableAction !== 'none'" class="mt-4 px-4 md:px-4 w-full">
        <button class="btn btn-blue-secondary w-full " @click="openBookableAction = 'none'">Cancel</button>
    </div>
    <div x-show.transition.duration.300ms="openBookableAction === 'addFlight'" class="mt-4 px-4">
        @livewire('add-bookable-flight', ['event' => $event])
    </div>
    <div x-show.transition.duration.300ms="openBookableAction === 'importFlights'" class="mt-4 px-4">
        @livewire('bookable-flight-import', ['event' => $event])
    </div>
</div>
