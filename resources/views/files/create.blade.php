@extends('layouts.app')

@section('content')
    <div class="row d-flex flex-row justify-content-center align-items-center">
        <div class="col-5 card p-0">
            <div class="card-header">Upload File</div>
            <div class="card-body">
                <form method="post" action="{{ route('file.new') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="title_span">Upload</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file" name="file" aria-describedby="file input">
                            <label class="custom-file-label" for="file">Choose file</label>
                        </div>
                    </div>
                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" class="custom-control-input" name="private" id="private">
                        <label class="custom-control-label" for="private">Will Upload Private</label>
                    </div>
                    <button class="btn btn-primary" type="submit">Upload File</button>
                </form>
                @include('partials.validation-errors')
            </div>
        </div>
    </div>
@endsection
