<div>
    <form wire:submit.prevent="save">
        <div class="mt-4">
            <button class="input w-full btn btn-blue">Save changes...</button>
        </div>
        <div class="mt-4">
            <input wire:model.lazy="title" class="input w-full" type="text" placeholder="Event title" required>
        </div>
        <div class="mt-4">
            <textarea wire:model.lazy="description" class="input w-full" placeholder="Event description...">
            </textarea>
        </div>
        <div class="mt-4 -mx-2 flex">
            <div class="px-2 w-1/2">
                <input wire:model.lazy="startDate" class="input w-full" type="date" placeholder="Start date" required>
            </div>
            <div class="px-2 w-1/2">
                <input wire:model.lazy="startTime" class="input w-full" type="time" placeholder="Start time" required>
            </div>
        </div>
        <div class="mt-4 -mx-2 flex">
            <div class="px-2 w-1/2">
                <input wire:model.lazy="endDate" class="input w-full" type="date" placeholder="End date" required>
            </div>
            <div class="px-2 w-1/2">
                <input wire:model.lazy="endTime" class="input w-full" type="time" placeholder="End time" required>
            </div>
        </div>
    </form>
</div>
