@extends('main')

@section('title', $event->name)

@section('main-content')

    @include('tenants.partials._nav')

    @component('tenants.office.components._office-title')
        {{ $office_title }} - {{ $event->title }}
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
                <a href="#" class="btn btn-info btn-block">Manage focus airports</a>
            </div>
            <div class="col-md-6 my-2">
                <a href="#" class="btn btn-info btn-block">Manage flights</a>
            </div>
            <div class="col-md-6 my-2">
                <a href="#" class="btn btn-info btn-block">Some other stuff.....</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('tenants.office.events.destroy', $event->slug) }}" method="post"
                      onsubmit="return confirm('Are you sure you want to permanently delete this event? This action cannot be undone.')">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-danger btn-block" type="submit">Permanently cancel / Delete event (THIS
                        ACTION CANNOT BE UNDONE)
                    </button>
                </form>
            </div>
        </div>
@endsection