<?php


namespace App\Services\Uploader;


use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StorageManager
{
    public function putFileAsPrivate(string $name, UploadedFile $file, string $type)
    {
        return Storage::disk('private')->putFileAs($type, $file, $name);
    }

    public function putFileAsPublic(string $name, UploadedFile $file, string $type)
    {
        return Storage::disk('public')->putFileAs($type, $file, $name);
    }

    function getAbsolutePathOf(string $name, string $type, bool $private): string
    {
        return $this->disk($private)->path($this->directoryPrefix($name, $type));
    }

    public function isFileExist(string $name, string $type, bool $isPrivate): bool
    {
        return $this->disk($isPrivate)->exists($this->directoryPrefix($name, $type));
    }

    private function directoryPrefix(string $name, string $type): string
    {
        return $type . DIRECTORY_SEPARATOR . $name;
    }

    private function disk(bool $private): Filesystem
    {
        return $private ? Storage::disk('private') : Storage::disk('public');
    }

    public function getFile(string $name, string $type, bool $isPrivate): StreamedResponse
    {
        return $this->disk($isPrivate)->download($this->directoryPrefix($name, $type));
    }

    public function deleteFile(string $name, string $type, bool $isPrivate): bool
    {
        return $this->disk($isPrivate)->delete($this->directoryPrefix($name, $type));
    }
}
