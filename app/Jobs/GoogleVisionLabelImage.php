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

class GoogleVisionLabelImage implements ShouldQueue
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

        $fullPath = storage_path('app/public/'.$i->path);

        if (! file_exists($fullPath)) {
            return;
        }

        $image = file_get_contents($fullPath);

        if ($image === false) {
            return;
        }

        putenv('GOOGLE_APPLICATION_CREDENTIALS='.$credentialsPath);

        $googleVisionClient = new ImageAnnotatorClient();

        $googleImage = (new VisionImage())->setContent($image);
        $googleFeature = (new Feature())->setType(Type::LABEL_DETECTION);
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

        $labels = $response->getLabelAnnotations();

        if ($labels) {
            $result = [];

            foreach ($labels as $label) {
                $result[] = $label->getDescription();
            }

            $i->labels = $result;
            $i->save();
        }
    }
}
