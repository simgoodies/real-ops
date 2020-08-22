<div x-data="{ openBookableAction: 'none'}">
    <div class="flex">
        <div x-show="openBookableAction === 'none'" class="mt-4 px-4 md:px-4 w-1/2">
            <button class="btn btn-blue w-full" @click="openBookableAction = 'addTimeSlot'">Add Time Slot</button>
        </div>
    </div>
    <div x-show="openBookableAction !== 'none'" class="mt-4 px-4 md:px-4 w-full">
        <button class="btn btn-blue-secondary w-full " @click="openBookableAction = 'none'">Cancel</button>
    </div>
    <div x-show.transition.duration.300ms="openBookableAction === 'addTimeSlot'" class="mt-4 px-4">
        @livewire('add-bookable-time-slot', ['event' => $event])
    </div>
</div>
