<?php


namespace App\Services\Uploader;


use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Http\Request;

class Uploader
{
    private Request $request;
    private StorageManager $storageManager;
    private $file;

    /**
     * Uploader constructor.
     * @param Request $request
     * @param StorageManager $storageManager
     */
    public function __construct(Request $request, StorageManager $storageManager)
    {
        $this->request = $request;
        $this->storageManager = $storageManager;
        $this->file = $request->file;
    }


    public function upload()
    {
        $this->putFileIntoStorage();
    }

    private function putFileIntoStorage()
    {
        $method = $this->request->has('private') ? 'putFileAsPrivate' : 'putFileAsPublic';
        $this->storageManager->$method($this->file->getClientOriginalName(), $this->file, $this->getType());
    }

    private function getType(): string
    {
        return [
            'image/jpeg' => 'image',
            'image/png' => 'image',
            'video/mp4' => 'video',
            'application/zip' => 'archive'
        ][$this->file->getClientMimeType()];
    }


}
