@extends('main')

@section('title', $event->name)

@section('main-content')

    @include('tenants.partials._nav')

    @component('tenants.office.components._office-title')
        {{ $tenant->name }} - {{ $event->title }}
    @endcomponent

    <div class="container">
        <div class="row my-3">
            <div class="col-md-12">
                <a href="{{ route('tenants.office.events.index') }}" class="btn btn-danger btn-block">
                    Return to events
                </a>
            </div>
        </div>

        @if ($event->banner_image_link)
            <div class="row">
                <div class="col-md-12">
                    <img src="{{ $event->banner_image_link }}"
                         class="img-fluid d-block mx-auto">
                </div>
            </div>
        @else
            <p class="text-center">{{ $event->description }}</p>
        @endif

        <div class="row my-2">
            <div class="col-md-6 my-2">
                <a href="{{ route('tenants.office.events.edit', ['slug' => $event->slug]) }}"
                   class="btn btn-info btn-block">Change event details</a>
            </div>
            <div class="col-md-6 my-2">
                <a href="{{ route('tenants.office.events.flights.index', ['slug' => $event->slug]) }}" class="btn btn-info btn-block">Manage Flights</a>
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <form class="delete" action="{{ route('tenants.office.events.destroy', $event->slug) }}" method="post" data-confirm="Are you sure you want to permanently delete this event? This action cannot be undone. Type the words: I UNDERSTAND">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-danger btn-block" type="submit">Permanently cancel / Delete event (THIS
                        ACTION CANNOT BE UNDONE)
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var deleteLinks = document.querySelectorAll('.delete');

        for (var i = 0; i < deleteLinks.length; i++) {
            deleteLinks[i].addEventListener('submit', function(event) {
                event.preventDefault();

                var choice = prompt(this.getAttribute('data-confirm'));
                if (choice == 'I UNDERSTAND') {
                    document.forms[0].submit();
                    return;
                }
                
                alert('The event has not been deleted as you have not correctly typed: I UNDERSTAND')
            });
        }
    </script>
@endsection
