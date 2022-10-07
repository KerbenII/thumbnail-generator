<?php

declare(strict_types=1);

namespace App\Thumbnail\Main\Application;

use Webmozart\Assert\Assert;

final class ThumbnailFormatExtension
{
    private const  FORMAT_EXTENSION_MAP = [
        'png' => 'png',
        'jpg' => 'jpg',
        'jpeg' => 'jpg',
        'webp' => 'webp'
    ];

    public function __construct(private readonly string $thumbnailFormat)
    {
        Assert::keyExists(
            self::FORMAT_EXTENSION_MAP,
            $thumbnailFormat,
            'Unsupported thumbnail format provided.'
        );
    }

    public function format(): string
    {
        return $this->thumbnailFormat;
    }

    public function extension(): string
    {
        return self::FORMAT_EXTENSION_MAP[$this->thumbnailFormat];
    }
}
