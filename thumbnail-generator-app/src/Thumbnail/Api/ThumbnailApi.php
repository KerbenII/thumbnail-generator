<?php

declare(strict_types=1);

namespace App\Thumbnail\Api;

use App\Thumbnail\Api\Input\Image;
use App\Thumbnail\Api\Output\Thumbnail;

interface ThumbnailApi
{
    public function generate(Image $image): Thumbnail;
}
