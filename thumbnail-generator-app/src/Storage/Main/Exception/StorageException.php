<?php

declare(strict_types=1);

namespace App\Storage\Main\Exception;

final class StorageException extends \Exception
{
    public static function forDownload(string $path, \Throwable $throwable): self
    {
        return new self(
            message: "Storage failed to download: $path",
            previous: $throwable
        );
    }

    public static function forUpload(string $name, \Throwable $throwable): self
    {
        return new self(
            message: "Storage failed to upload: $name",
            previous: $throwable
        );
    }
}
