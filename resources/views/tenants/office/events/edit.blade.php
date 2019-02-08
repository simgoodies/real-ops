@extends('main')

@section('title', 'Organize event')

@section('main-content')

    @include('tenants.partials._nav')

    @component('tenants.office.components._office-title')
        {{ $office_title }} - {{ $event->title }} - Edit
    @endcomponent

    <div class="container">
        <div class="row my-3">
            <div class="offset-md-2 col-md-8">
                <a href="{{ route('tenants.office.events.index') }}" class="btn btn-danger btn-block">
                    Return to event management
                </a>
            </div>
        </div>
        <div class="row">
            <div class="offset-md-1 col-md-10">

                @include('partials._errors')

                <form action="{{ route('tenants.office.events.update', $event->slug) }}" method="POST">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title">Event title* :</label>
                                <input type="text" class="form-control" name="title" required="true"
                                       value="{{ old('title', $event->title) }}"
                                       placeholder="Enter the title of the real ops event...">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Event description* :</label>
                                <textarea name="description" class="form-control" required="true"
                                          placeholder="Enter the event description / invitation message to pilots..."
                                          cols="30"
                                          rows="10">{{ old('description', $event->description) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="start_date">Event start date* :</label>
                                <div class="input-group date">
                                    <input type="date" name="start_date" class="form-control"
                                           value="{{ old('start_date', $event->start_date) }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="start_time">Event start time* : (in ZULU)</label>
                                <div class="input-group date">
                                    <input type="time" name="start_time" class="form-control"
                                           value="{{ old('start_time', $event->start_time) }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="end_date">Event end date* :</label>
                                <div class="input-group date">
                                    <input type="date" name="end_date" class="form-control"
                                           value="{{ old('end_date', $event->end_date) }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="end_time">Event end time* : (in ZULU)</label>
                                <div class="input-group date">
                                    <input type="time" name="end_time" class="form-control"
                                           value="{{ old('end_time', $event->end_time) }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="banner_image_link">Event Banner:</label>
                                <input type="text" class="form-control" name="banner_image_link"
                                       value="{{ old('banner_image_link', $event->banner_image_link) }}"
                                       placeholder="Enter the permalink to the event banner...">
                                <small class="form-text text-muted">
                                    For example: https://theplace.wheretheimageis.com/images/banner.jpg
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 ml-auto">
                            <button type="submit" class="btn btn-success btn-block">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection