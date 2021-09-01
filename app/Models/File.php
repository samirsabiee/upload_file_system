<?php

namespace App\Models;

use App\Services\Uploader\StorageManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'size', 'time', 'type', 'is_private'];

    public function isMedia(): bool
    {
        return $this->type === 'video';
    }

    public function absolutePath()
    {
        return resolve(StorageManager::class)->getAbsolutePathOf($this->name, $this->type, $this->is_private);
    }

    public function toMegabyteSize(): string
    {
        return number_format($this->size / (1024 * 1024), 2);
    }

    public function download()
    {
        return resolve(StorageManager::class)->getFile($this->name, $this->type, $this->is_private);
    }

    public function removeFile(): ?bool
    {
        return $this->removeFromStorage() ? $this->delete() : false;
    }

    private function removeFromStorage()
    {
        return resolve(StorageManager::class)->deleteFile($this->name, $this->type, $this->is_private);
    }
}
