@if (Session::has('success'))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                <strong>Success:</strong> {{ Session::get('success') }}
            </div>
        </div>
    </div>
@endif

@if (Session::has('failure'))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger">
                <strong>Failure:</strong> {{ Session::get('failure') }}
            </div>
        </div>
    </div>
@endif

@if (count($errors) > 0)
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="alert alert-danger" role="alert">
                <strong>Errors:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
