@extends('layout')
@section('title', 'Api key Setting')

@section('content')
    <div class="container-fluid">
        <!-- begin row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-statistics">
                    <div class="card-header">
                        <div class="card-heading">
                            <h4 class="card-title">Api key Setting</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('update.api.key') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            @if (session()->has('success'))
                                <div class="alert alert-icon alert-inverse-success mt-5" role="alert">
                                    <i class="fa fa-info-circle"></i> {{ session()->get('success') }}!
                                </div>
                            @endif


                            @if (session()->has('error'))
                                <div class="alert alert-icon alert-inverse-danger mt-5" role="alert">
                                    <i class="fa fa-info-circle"></i> {{ session()->get('error') }}!
                                </div>
                            @endif

                            <div class="form-row mt-2">

                                <div class="col-md-10 mb-3">
                                    <label for="originalImage">CLIPDROP API KEY</label>
                                    <input type="text" class="form-control" name="key" value="{{ config('services.clipdrop_api_key') }}">

                                </div>
                            </div>

                            <button id="submitButton" class="btn btn-primary" type="submit">
                                <span id="submitText">Submit</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <!-- end row -->
    </div>
@endsection
