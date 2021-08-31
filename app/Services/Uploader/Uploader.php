<?php


namespace App\Services\Uploader;


use App\Exceptions\FileHasExistException;
use App\Models\File;
use Illuminate\Http\Request;

class Uploader
{
    private Request $request;
    private StorageManager $storageManager;
    private FFMpegService $ffmpeg;
    private $file;

    /**
     * Uploader constructor.
     * @param Request $request
     * @param StorageManager $storageManager
     * @param FFMpegService $ffmpeg
     */
    public function __construct(Request $request, StorageManager $storageManager, FFMpegService $ffmpeg)
    {
        $this->request = $request;
        $this->storageManager = $storageManager;
        $this->file = $request->file;
        $this->ffmpeg = $ffmpeg;

    }

    /**
     * @throws FileHasExistException
     */
    public function upload()
    {
        if ($this->isFileExist()) throw new FileHasExistException();
        $this->putFileIntoStorage();
        $this->saveFileIntoDatabase();
    }

    private function saveFileIntoDatabase()
    {
        $file = new File([
            'name' => $this->file->getClientOriginalName(),
            'size' => $this->file->getSize(),
            'type' => $this->getType(),
            'is_private' => $this->isPrivate()
        ]);
        $file->time = $this->getTime($file);
        $file->save();
    }

    private function getTime(File $file)
    {
        if (!$file->isMedia()) return null;

        return $this->ffmpeg->durationOf($file->absolutePath());
    }

    private function putFileIntoStorage()
    {
        $method = $this->isPrivate() ? 'putFileAsPrivate' : 'putFileAsPublic';
        $this->storageManager->$method($this->file->getClientOriginalName(), $this->file, $this->getType());
    }

    private function isFileExist(): bool
    {
        return $this->storageManager->isFileExist($this->file->getClientOriginalName(), $this->getType(), $this->isPrivate());
    }

    private
    function isPrivate(): bool
    {
        return $this->request->has('is_private');
    }

    private
    function getType(): string
    {
        return [
            'image/jpeg' => 'image',
            'image/png' => 'image',
            'video/mp4' => 'video',
            'application/zip' => 'archive'
        ][$this->file->getClientMimeType()];
    }


}
