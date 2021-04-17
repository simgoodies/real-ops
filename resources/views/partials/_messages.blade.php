@if (session()->has('success') || request()->has('success'))
    <div class="p-2 text-green-800 bg-green-200 border-2 border-green-700">
        {{ session()->get('success') ?? request()->get('success') }}
    </div>
@endif
@if (session()->has('failure') || request()->has('failure'))
    <div class="p-2 text-red-800 bg-red-200 border-2 border-red-700">
        {{ session()->get('failure') ?? request()->get('failure') }}
    </div>
@endif
@if (session()->has('info') || request()->has('info'))
    <div class="p-2 text-blue-800 bg-blue-200 border-2 border-blue-700">
        {{ session()->get('info') ?? request()->get('info') }}
    </div>
@endif
