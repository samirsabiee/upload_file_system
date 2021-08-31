<?php

namespace App\Http\Controllers;

use App\Exceptions\FileHasExistException;
use App\Http\Requests\FileRequest;
use App\Services\Uploader\StorageManager;
use App\Services\Uploader\Uploader;
use Exception;
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
        try {
            $this->uploader->upload();
            return redirect()->back()->with('success', 'File Uploaded Successfully');
        } catch (FileHasExistException $e) {
            return redirect()->back()->with('error', 'File Exist can\'t upload again');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
