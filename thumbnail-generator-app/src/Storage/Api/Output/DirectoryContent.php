<?php

declare(strict_types=1);

namespace App\Storage\Api\Output;

use Webmozart\Assert\Assert;

final class DirectoryContent
{
    public function __construct(public readonly array $paths)
    {
        Assert::allIsInstanceOf($paths, Path::class);
    }
}
