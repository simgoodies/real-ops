<div>
    <form wire:submit.prevent="import">
        <input wire:model="file" type="file">
        <button>Upload</button>
        @error('file')
        <div class="text-red-800">
            {{ $message }}
        </div>
        @enderror
    </form>
</div>
