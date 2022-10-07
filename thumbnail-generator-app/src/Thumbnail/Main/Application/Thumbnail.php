<?php

declare(strict_types=1);

namespace App\Thumbnail\Main\Application;

final class Thumbnail
{
    public function __construct(
        public readonly string $blob,
        public readonly string $extension,
    ) {
    }
}
