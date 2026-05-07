<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Spatie\Image\Enums\CropPosition;
use Spatie\Image\Enums\Unit;
use Spatie\Image\Image;

class ResizeImage implements ShouldQueue
{
    use Dispatchable;
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
            ->watermark(
                base_path('resources/img/watermark.png'),
                width: 50,
                height: 50,
                paddingX: 5,
                paddingY: 5,
                paddingUnit: Unit::Percent,
            )
            ->save($destPath);
    }
}
