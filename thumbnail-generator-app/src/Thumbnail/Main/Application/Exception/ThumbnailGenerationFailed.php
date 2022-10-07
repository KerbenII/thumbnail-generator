<?php

declare(strict_types=1);

namespace App\Thumbnail\Main\Application\Exception;

final class ThumbnailGenerationFailed extends \Exception
{
    public static function forInvalidPathProvided(string $path): self
    {
        return new self("Invalid image path provided: $path");
    }

    public static function forThirtParty(string $path, \Throwable $throwable): self
    {
        return new self(
            message: "Generator failed to generate image: $path",
            previous: $throwable
        );
    }
}
