<?php

declare(strict_types=1);

namespace App\Thumbnail\Api\Output;

class Thumbnail
{
    public function __construct(
        public readonly string $blob,
        public readonly string $fileName
    ) {
    }
}
