<div>
    <form wire:submit.prevent="save">
        <div x-data="{showHelp: false}" class="mt-4">
            <div class="-mx-2 flex">
                <div class="px-2 w-1/2">
                    <label for="startDate">
                        Time Slot Start Date*
                    </label>
                    <i @click="showHelp = !showHelp" class="far fa-question-circle"></i>
                </div>
                <div class="px-2 w-1/2">
                    <input id="startDate" wire:model.lazy="startDate" class="input w-full" type="date" placeholder="Time Slot Start Date" required>
                </div>
            </div>
            <div x-show="showHelp" @click.away="showHelp = false" class="mt-4 px-2 py-1 border-2 rounded border-blue-300 bg-white">
                The starting date of this time slot.
            </div>
            @error('startDate')
                <div class="text-red-800">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div x-data="{showHelp: false}" class="mt-4">
            <div class="mt-4 -mx-2 flex">
                <div class="px-2 w-1/2">
                    <label for="startTime">
                        Time Slot Start Time*
                    </label>
                    <i @click="showHelp = !showHelp" class="far fa-question-circle"></i>
                </div>
                <div class="px-2 w-1/2">
                    <input id="startTime" wire:model.lazy="startTime" class="input w-full" type="time" placeholder="Time Slot Start Time" required>
                </div>
            </div>
            <div x-show="showHelp" @click.away="showHelp = false" class="mt-4 px-2 py-1 border-2 rounded border-blue-300 bg-white">
                The starting time of this time slot
            </div>
            @error('startTime')
                <div class="text-red-800">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div x-data="{showHelp: false}" class="mt-4">
            <div class="-mx-2 flex">
                <div class="px-2 w-1/2">
                    <label for="duration">
                        Time Slot Duration*
                    </label>
                    <i @click="showHelp = !showHelp" class="far fa-question-circle"></i>
                </div>
                <div class="px-2 w-1/2">
                    <select id="duration" wire:model.lazy="duration" class="input w-full">
                        <option value="{{ \App\Models\BookableTimeSlot::DURATION_HALFHOUR }}">30 minutes</option>
                        <option value="{{ \App\Models\BookableTimeSlot::DURATION_HOUR }}">1 hour</option>
                    </select>
                </div>
            </div>
            <div x-show="showHelp" @click.away="showHelp = false" class="mt-4 px-2 py-1 border-2 rounded border-blue-300 bg-white">
                How long should this time slot take? This will determine the ending of the time slot based on the beginning of the time slot.
            </div>
            @error('duration')
                <div class="text-red-800">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div x-data="{showHelp: false}" class="mt-4">
            <div class="-mx-2 flex">
                <div class="px-2 w-1/2">
                    <label for="available-bookables">
                        Available Bookables*
                    </label>
                    <i @click="showHelp = !showHelp" class="far fa-question-circle"></i>
                </div>
                <div class="px-2 w-1/2">
                    <input wire:model.lazy="availableBookables" class="input w-full" id="available-bookables" type="number" step="1" min="1" placeholder="{{ $placeholderAvailableBookables }}">
                </div>
            </div>
            <div x-show="showHelp" @click.away="showHelp = false" class="mt-4 px-2 py-1 border-2 rounded border-blue-300 bg-white">
                How many booking should be available for this specific time slot?
                <br>
                e.g. If you have a 30 minute time slot with 15 available bookings, then you can expect approximately one activity every two minutes.
            </div>
            @error('availableBookables')
                <div class="text-red-800">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div x-data="{showHelp: false}" class="mt-4">
            <div class="-mx-2 flex">
                <div class="px-2 w-1/2">
                    <label for="direction">
                        Flight Direction*
                    </label>
                    <i @click="showHelp = !showHelp" class="far fa-question-circle"></i>
                </div>
                <div class="px-2 w-1/2">
                    <select wire:model.lazy="direction" class="input w-full">
                        <option value="{{ \App\Models\BookableTimeSlot::DIRECTION_ANY }}">Any</option>
                        <option value="{{ \App\Models\BookableTimeSlot::DIRECTION_OUTBOUND }}">Outbound</option>
                        <option value="{{ \App\Models\BookableTimeSlot::DIRECTION_INBOUND }}">Inbound</option>
                    </select>
                </div>
            </div>
            <div x-show="showHelp" @click.away="showHelp = false" class="mt-4 px-2 py-1 border-2 rounded border-blue-300 bg-white">
                What flight direction is this time slot focused on?<br><br>
                If you want to specify different available bookings based on the flight direction you can do so here.<br><br>
                If you are including both inbound and outbound activities in your timeslot, use the 'any' option.
            </div>
            @error('direction')
                <div class="text-red-800">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div x-data="{showHelp: false}" class="mt-4">
            <div class="mt-4 -mx-2 flex">
                <div class="px-2 w-1/2">
                    <label for="assignation">
                        Slot Airport ICAO or Area ICAO
                    </label>
                    <i @click="showHelp = !showHelp" class="far fa-question-circle"></i>
                </div>
                <div class="px-2 w-1/2">
                    <input wire:model="assignation" list="assignation-list" class="awesomplete input w-full" id="assignation" type="text" placeholder="e.g. EHAM / e.g. EHAA">
                    <datalist id="assignation-list">
                        @foreach($assignations as $assignation)
                            <option>{{ $assignation }}</option>
                        @endforeach
                    </datalist>
                </div>
            </div>
            <div x-show="showHelp" @click.away="showHelp = false" class="mt-4 px-2 py-1 border-2 rounded border-blue-300 bg-white">
                You can specify here what the focus area is of your time slot. <br>
                If you want to provide more activity for a major airport/area and less activity for a smaller airport/area you can specify this here.
                <br><br>
                e.g. EHAM or e.g. EHAA.
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
