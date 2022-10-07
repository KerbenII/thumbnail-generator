<?php

declare(strict_types=1);

namespace App\Storage\Main;

interface PathInterface
{
    public function getAbsolutePath(string $fileName): string;
}
