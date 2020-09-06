<div>
    @include('partials._navigation')

    <div class="container mx-auto">
        @include('partials._page-heading', ['title' => 'Manage Staff'])
        @include('partials._messages')

        <div class="mt-8 px-4">
            <h2 class="text-lg">Invite staff member</h2>
            <hr class="mt-2">
        </div>

        <div class="mt-4 px-4">
            <div class="flex flex-col">
                <input class="input" type="text" placeholder="inviteduser@example.org">
                <button class="mt-4 btn btn-blue">Invite to {{ tenant('name') }}</button>
            </div>
        </div>

        <div class="mt-12 px-4">
            <h2 class="text-lg">Remove staff member(s)</h2>
            <hr class="mt-2">
        </div>

        <div class="mt-4 px-4">
            @foreach($members as $member)
                <div class="flex mt-4">
                    <div>
                        <div>
                            {{ $member->name }}
                        </div>
                        <div>
                            {{ $member->email }}
                        </div>
                    </div>
                    <button class="btn btn-red-secondary ml-auto">
                        Remove
                    </button>
                </div>
            @endforeach
        </div>
    </div>
</div>
