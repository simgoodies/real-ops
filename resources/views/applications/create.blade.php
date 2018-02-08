@extends('main')

@section('title', 'Become VATGoodies Real Ops Member')

@section('content')
    <h1>VATGoodies Real Ops - FIR / ARTCC Application Form</h1>
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <div class="content-wrapper">
                <form action="{{ route('applications.store') }}" method="post" class="application-create">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="fir_name">FIR / ARTCC Name:</label>
                                <input type="text" class="form-control" name="fir_name" value="{{ old('fir_name') }}"
                                       required="true"
                                       placeholder="Enter FIR / ARTCC Name...">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contact_first_name">Contact First Name:</label>
                                <input type="text" class="form-control" name="contact_first_name"
                                       value="{{ old('contact_first_name') }}" required="true"
                                       placeholder="Enter your first name...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contact_last_name">Contact Last Name:</label>
                                <input type="text" class="form-control" name="contact_last_name"
                                       value="{{ old('contact_last_name') }}" required="true"
                                       placeholder="Enter your last name...">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="contact_email">Contact Email:</label>
                                <input type="email" class="form-control" name="contact_email"
                                       value="{{ old('contact_email') }}"
                                       required="true"
                                       placeholder="Enter an email address for contact purposes...">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="icao">VATSIM CID:</label>
                                <input type="number" class="form-control" name="vatsim_id"
                                       value="{{ old('vatsim_id') }}"
                                       required="true"
                                       placeholder="Enter your VATSIM ID...">

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="icao">ICAO:</label>
                                <input type="text" class="form-control" name="icao" value="{{ old('icao') }}"
                                       required="true"
                                       placeholder="Enter ICAO Code...">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="motivation">Motivation:</label>
                                <textarea name="motivation" class="form-control" required="true"
                                          placeholder="Enter your motivation for wanting to apply to VATGoodies Real Ops..."
                                          cols="30" rows="10">{{ old('motivation') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Apply for VATGoodies Real Ops</button>
                </form>
            </div>
        </div>
    </div>
@endsection