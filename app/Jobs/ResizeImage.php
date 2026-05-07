<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Spatie\Image\Enums\CropPosition;
use Spatie\Image\Image;

class ResizeImage implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private int $w,
        private int $h,
        private string $path,
        private string $fileName,
    ) {
    }

    /**
     * Create a new job instance.
     */
    public function handle(): void
    {
        $w = $this->w;
        $h = $this->h;
        $srcPath = storage_path().'/app/public/'.$this->path.'/'.$this->fileName;
        $destPath = storage_path().'/app/public/'.$this->path."/crop_{$w}x{$h}_".$this->fileName;

        if (! file_exists($srcPath)) {
            return;
        }

        Image::load($srcPath)
            ->crop($w, $h, CropPosition::Center)
            ->save($destPath);
    }
}
