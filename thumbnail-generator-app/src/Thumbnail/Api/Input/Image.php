<?php

declare(strict_types=1);

namespace App\Thumbnail\Api\Input;

final class Image
{
    public function __construct(public readonly string $path)
    {
    }
}
