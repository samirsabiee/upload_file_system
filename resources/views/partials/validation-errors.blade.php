@if($errors->any())
    @foreach($errors->all() as $error)
        <div class="mt-2">
            <li class="text-danger"> {{ $error }}</li>
        </div>
    @endforeach
@endif
