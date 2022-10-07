<?php

declare(strict_types=1);

namespace App\Thumbnail\Main\Application;

final class ThumbnailGenerationRequest
{
    public function __construct(public readonly string $path)
    {
    }
}
