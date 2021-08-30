<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Services\Uploader\StorageManager;
use App\Services\Uploader\Uploader;
use Illuminate\Http\RedirectResponse;

class FileController extends Controller
{
    private Uploader $uploader;

    /**
     * FileController constructor.
     * @param Uploader $uploader
     */
    public function __construct(Uploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function create()
    {
        return view('files.create');
    }

    public function new(FileRequest $request): RedirectResponse
    {
        $this->uploader->upload();
        return redirect()->back()->with('success', 'File Uploaded Successfully');
    }
}
