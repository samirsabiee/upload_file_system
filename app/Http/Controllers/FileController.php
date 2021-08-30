<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;

class FileController extends Controller
{
    public function create()
    {
        return view('files.create');
    }

    public function new(FileRequest $request)
    {
        dd($request->file);
    }
}
