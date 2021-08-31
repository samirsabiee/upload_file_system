<?php


namespace App\Services\Uploader;


use Alchemy\BinaryDriver\Configuration;
use Alchemy\BinaryDriver\ConfigurationInterface;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;

class FFMpegService
{
    private $ffprobe;

    /**
     * FFMpegService constructor.
     */
    public function __construct()
    {
        $this->ffprobe = FFProbe::create([
            'ffprobe.binaries' => config('services.ffmpeg.ffprobe_path')
        ]);
    }

    public function durationOf(string $path)
    {
        return $this->ffprobe->format($path)->get('duration');
    }
}
