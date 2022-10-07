<?php

declare(strict_types=1);

namespace App\Storage\Main;

final class LocalPath implements PathInterface
{
    public function __construct(
        private readonly string $mountLocation
    ) {
    }
    public function getAbsolutePath(string $fileName): string
    {
        return $this->mountLocation . $fileName;
    }
}
