@if ($errors->any())
    <div class="p-2 bg-red-200 text-red-800 border-2 border-red-700">
        <h4 class="font-bold">Errors:</h4>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
