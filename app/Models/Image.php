<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $fillable = [
        'path',
        'article_id',
        'adult',
        'spoof',
        'medical',
        'violence',
        'racy',
        'labels',
    ];

    protected $casts = [
        'labels' => 'array',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public static function getUrlByFilePath(string $filePath, ?int $w = null, ?int $h = null): string
    {
        if ($w && $h) {
            $directory = dirname($filePath);
            $fileName = basename($filePath);
            $prefix = "crop_{$w}x{$h}_";
            $croppedPath = ($directory === '.' ? '' : $directory.'/').$prefix.$fileName;

            if (Storage::disk('public')->exists($croppedPath)) {
                return Storage::url($croppedPath);
            }
        }

        return Storage::url($filePath);
    }

    public function getUrl(?int $w = null, ?int $h = null): string
    {
        return self::getUrlByFilePath($this->path, $w, $h);
    }
}
