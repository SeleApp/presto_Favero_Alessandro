<?php

namespace App\Jobs;

use App\Models\Image;
use Google\Cloud\Vision\V1\AnnotateImageRequest;
use Google\Cloud\Vision\V1\BatchAnnotateImagesRequest;
use Google\Cloud\Vision\V1\Client\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\Feature;
use Google\Cloud\Vision\V1\Feature\Type;
use Google\Cloud\Vision\V1\Image as VisionImage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Spatie\Image\Enums\AlignPosition;
use Spatie\Image\Enums\Fit;
use Spatie\Image\Enums\Unit;
use Spatie\Image\Image as SpatieImage;

class GoogleVisionRemoveFaces implements ShouldQueue
{
    use Dispatchable;
    use Queueable;

    public function __construct(private int $article_image_id)
    {
    }

    /**
     * Create a new job instance.
     */
    public function handle(): void
    {
        $i = Image::find($this->article_image_id);

        if (! $i) {
            return;
        }

        $credentialsPath = base_path('google_credential.json');

        if (! file_exists($credentialsPath)) {
            return;
        }

        $directory = dirname($i->path);
        $fileName = basename($i->path);
        $croppedRelativePath = ($directory === '.' ? '' : $directory.'/')."crop_300x300_{$fileName}";
        $targetRelativePath = $croppedRelativePath;
        $targetPath = storage_path('app/public/'.$targetRelativePath);

        if (! file_exists($targetPath)) {
            $targetRelativePath = $i->path;
            $targetPath = storage_path('app/public/'.$targetRelativePath);
        }

        if (! file_exists($targetPath)) {
            return;
        }

        $imageContent = file_get_contents($targetPath);

        if ($imageContent === false) {
            return;
        }

        putenv('GOOGLE_APPLICATION_CREDENTIALS='.$credentialsPath);

        $googleVisionClient = new ImageAnnotatorClient();

        $googleImage = (new VisionImage())->setContent($imageContent);
        $googleFeature = (new Feature())->setType(Type::FACE_DETECTION);
        $annotateRequest = (new AnnotateImageRequest())
            ->setImage($googleImage)
            ->setFeatures([$googleFeature]);

        $batchRequest = (new BatchAnnotateImagesRequest())
            ->setRequests([$annotateRequest]);

        $batchResponse = $googleVisionClient->batchAnnotateImages($batchRequest);
        $response = $batchResponse->getResponses()[0] ?? null;

        $googleVisionClient->close();

        if (! $response) {
            return;
        }

        $faces = $response->getFaceAnnotations();

        if (count($faces) === 0) {
            return;
        }

        $censorPath = public_path('img/censor.png');

        if (! file_exists($censorPath)) {
            return;
        }

        $spatieImage = SpatieImage::load($targetPath);

        foreach ($faces as $face) {
            $vertices = $face->getFdBoundingPoly()?->getVertices() ?? [];

            if (count($vertices) < 2) {
                continue;
            }

            $xs = [];
            $ys = [];

            foreach ($vertices as $vertex) {
                if ($vertex->getX() !== null) {
                    $xs[] = $vertex->getX();
                }

                if ($vertex->getY() !== null) {
                    $ys[] = $vertex->getY();
                }
            }

            if (empty($xs) || empty($ys)) {
                continue;
            }

            $minX = max(0, min($xs));
            $maxX = max(0, max($xs));
            $minY = max(0, min($ys));
            $maxY = max(0, max($ys));

            $width = max(1, $maxX - $minX);
            $height = max(1, $maxY - $minY);

            $spatieImage->watermark(
                $censorPath,
                AlignPosition::TopLeft,
                $minX,
                $minY,
                Unit::Pixel,
                $width,
                Unit::Pixel,
                $height,
                Unit::Pixel,
                Fit::Fill,
                100
            );
        }

        $spatieImage->save($targetPath);
    }
}
