<div>
    <div class="px-6 py-4 my-4 font-light rounded bg-white border-2 border-blue-200">
        An easier way to add flights to your event is to import them from a spreadsheet. comma separated values files (csv) are supported for import.
        <br>
        You can download the template of the spreadsheet below.
        <br>
        Each row will represent one flight. Make sure to follow the format given in the template.
        <br>
        When you have populated the spreadsheet with your flights, you can upload the file here and have them imported.
        <br><br>
        <span class="font-bold">Important Notes:</span>
        <br>
        All times are given in zulu format and should only contain digits! E.g. 0300 or 1500 and <span class="font-semibold">NOT</span> 12:00pm or 14:30am.
        <br>
        If you leave the date columns empty, the date for the booking will be the same as the event date!
        <br>
        All dates are given in the following format: yyyy-mm-dd e.g 2020-12-31
    </div>
    <div class="w-full">
        <a class="btn btn-blue-secondary block" href="{{ route('download-flight-template') }}">Download Template</a>
    </div>
    <form wire:submit.prevent="import">
            <input wire:model="file" class="mt-4 w-full" type="file">
            <button class="btn btn-blue mt-4 w-full">Upload</button>
        @error('file')
        <div class="text-red-800">
            {{ $message }}
        </div>
        @enderror
    </form>
</div>
