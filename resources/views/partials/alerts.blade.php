@if(session('success'))
    <div class="alert alert-success mx-3">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger mx-3">
        {{ session('error') }}
    </div>
@endif

@if(session('successOrder'))
    <div class="alert alert-success mx-3">
        {{ session('successOrder') }}
    </div>
@endif
