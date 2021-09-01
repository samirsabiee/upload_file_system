@extends('layouts.app')

@section('content')
    <div class="row d-flex flex-column justify-content-center align-items-center">

        <table class="table table-hover table-bordered col-8">
            <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Size</th>
                <th>Time</th>
                <th>Access</th>
                <th>Operation</th>
            </tr>
            </thead>
            <tbody>
            @foreach($files as $file)
                <tr>
                    <td>{{ $file->name }}</td>
                    <td>{{ $file->type }}</td>
                    <td>{{ $file->toMegabyteSize() }} Megabyte</td>
                    <td>{{ $file->time }}</td>
                    @if($file->is_private)
                        <td>private</td>
                    @else
                        <td>public</td>
                    @endif
                    <td>
                        <a href="{{ route('file.show', $file->id) }}" class="btn btn-sm btn-primary">Download</a>
                        <form action="{{ route('file.delete',$file->id) }}" method="post" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-primary">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
