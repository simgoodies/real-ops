@if (session()->has('success'))
    <div class="p-2 bg-green-200 text-green-800 border-2 border-green-700">
        {{ session()->get('success') }}
    </div>
@endif
@if (session()->has('failure'))
    <div class="p-2 bg-red-200 text-red-800 border-2 border-red-700">
        {{ session()->get('failure') }}
    </div>
@endif
