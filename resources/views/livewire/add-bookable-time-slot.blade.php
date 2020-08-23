<div>
    <form wire:submit.prevent="save">
        <div class="mt-4 -mx-2 flex">
            <label class="px-2 my-auto w-1/2" for="startDate">
                Time Slot Start Date*
            </label>
            <div class="px-2 w-1/2">
                <input id="startDate" wire:model.lazy="startDate" class="input w-full" type="date" placeholder="Time Slot Start Date" required>
            </div>
        </div>
        @error('startDate')
        <div class="text-red-800">
            {{ $message }}
        </div>
        @enderror
        <div class="mt-4 -mx-2 flex">
            <label class="px-2 my-auto w-1/2" for="startTime">
                Time Slot Start Time*
            </label>
            <div class="px-2 w-1/2">
                <input id="startTime" wire:model.lazy="startTime" class="input w-full" type="time" placeholder="Time Slot Start Time" required>
            </div>
        </div>
        @error('startTime')
        <div class="text-red-800">
            {{ $message }}
        </div>
        @enderror
        <div class="mt-4">
            <div class="mt-4 -mx-2 flex">
                <label class="px-2 my-auto w-1/2" for="duration">
                    Time Slot Duration*
                </label>
                <div class="px-2 w-1/2">
                    <select id="duration" wire:model.lazy="duration" class="input w-full">
                        <option value="{{ \App\Models\BookableTimeSlot::DURATION_HALFHOUR }}">30 minutes</option>
                        <option value="{{ \App\Models\BookableTimeSlot::DURATION_HOUR }}">1 hour</option>
                    </select>
                </div>
            </div>
        </div>
        @error('duration')
        <div class="text-red-800">
            {{ $message }}
        </div>
        @enderror
        <div class="mt-4">
            <div class="mt-4 -mx-2 flex">
                <label class="px-2 my-auto w-1/2" for="available-bookables">
                    Available Bookables*
                </label>
                <div class="px-2 w-1/2">
                    <input wire:model.lazy="availableBookables" class="input w-full" id="available-bookables" type="number" step="1" min="1" placeholder="{{ $placeholderAvailableBookables }}">
                </div>
            </div>
            @error('availableBookables')
            <div class="text-red-800">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="mt-4">
            <div class="mt-4 -mx-2 flex">
                <label class="px-2 my-auto w-1/2" for="direction">
                    Flight Direction*
                </label>
                <div class="px-2 w-1/2">
                    <select wire:model.lazy="direction" class="input w-full">
                        <option value="{{ \App\Models\BookableTimeSlot::DIRECTION_ANY }}">Any</option>
                        <option value="{{ \App\Models\BookableTimeSlot::DIRECTION_OUTBOUND }}">Outbound</option>
                        <option value="{{ \App\Models\BookableTimeSlot::DIRECTION_INBOUND }}">Inbound</option>
                    </select>
                </div>
            </div>
        </div>
        @error('direction')
        <div class="text-red-800">
            {{ $message }}
        </div>
        @enderror
        <div class="mt-4">
            <div class="mt-4 -mx-2 flex">
                <label class="px-2 my-auto w-1/2" for="assignation">
                    Time Slot Assignation
                </label>
                <div class="px-2 w-1/2">
                    <input wire:model.lazy="assignation" list="assignation-list" class="awesomplete input w-full" id="assignation" type="text" placeholder="Slot assignation">
                    <datalist id="assignation-list">
                        @foreach($assignations as $assignation)
                            <option>{{ $assignation }}</option>
                        @endforeach
                    </datalist>
                </div>
            </div>
            @error('assignation')
            <div class="text-red-800">
                {{ $message }}
            </div>
            @enderror
        </div>
        @if ($added)
            <div class="mt-2 p-2 text-blue-300 bg-blue-50 border-2 border-blue-500">
                Time slot was added!
            </div>
        @endif
        <div class="mt-4">
            <button type="submit" class="input w-full btn btn-blue">Add time slot</button>
        </div>
    </form>
</div>
