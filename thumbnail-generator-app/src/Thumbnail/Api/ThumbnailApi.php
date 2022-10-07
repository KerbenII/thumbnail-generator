<?php

declare(strict_types=1);

namespace App\Thumbnail\Api;

use App\Thumbnail\Api\Input\Image;
use App\Thumbnail\Api\Output\Thumbnail;
use App\Thumbnail\Main\Application\Exception\ThumbnailGenerationFailed;

interface ThumbnailApi
{
    /**
     * @throws ThumbnailGenerationFailed
     */
    public function generate(Image $image): Thumbnail;
}
