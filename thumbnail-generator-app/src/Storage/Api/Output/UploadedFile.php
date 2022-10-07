<?php

declare(strict_types=1);

namespace App\Storage\Api\Output;

final class UploadedFile
{
    public function __construct(public readonly string $path)
    {
    }
}
