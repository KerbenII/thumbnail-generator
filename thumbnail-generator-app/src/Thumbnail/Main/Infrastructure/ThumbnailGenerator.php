<?php

declare(strict_types=1);

namespace App\Thumbnail\Main\Infrastructure;

use App\Thumbnail\Main\Application\ThumbnailFormatExtension;
use App\Thumbnail\Main\Application\Thumbnail;
use App\Thumbnail\Main\Application\ThumbnailGenerationRequest;

final class ThumbnailGenerator
{
    private readonly ThumbnailFormatExtension $thumbnailFormatExtension;

    public function __construct(
        string $thumbnailFormat,
        private readonly int $compressionQuality,
        private readonly int $maximumLength,
    ) {
        $this->thumbnailFormatExtension = new ThumbnailFormatExtension($thumbnailFormat);
    }

    /**
     * @throws \ImagickException
     */
    public function generate(ThumbnailGenerationRequest $image): Thumbnail
    {
        $imagick = new \Imagick($image->path);
        $imagick->setImageFormat($this->thumbnailFormatExtension->format());
        $imagick->setImageCompression(\Imagick::COMPRESSION_JPEG2000);
        $imagick->setImageCompressionQuality($this->compressionQuality);
        $imagick->thumbnailImage(
            $this->maximumLength,
            $this->maximumLength,
            true
        );

        return new Thumbnail(
            $imagick->getImageBlob(),
            $this->thumbnailFormatExtension->extension()
        );
    }
}
