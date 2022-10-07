<?php

declare(strict_types=1);

namespace App\Storage\Api\Input;

final class File
{
    public function __construct(public readonly string $blob, public readonly string $fileName)
    {
    }
}
