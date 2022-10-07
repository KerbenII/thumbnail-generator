<?php

declare(strict_types=1);

namespace App\Thumbnail\Api;

use App\Thumbnail\Api\Input\Image;
use App\Thumbnail\Api\Output\Thumbnail;
use App\Thumbnail\Main\Application\Exception\ThumbnailGenerationFailed;
use App\Thumbnail\Main\Application\ThumbnailGenerationRequest;
use App\Thumbnail\Main\Infrastructure\ThumbnailGenerator;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Path;
use ImagickException;

final class ThumbnailApiInternal implements ThumbnailApi
{
    public function __construct(
        private readonly ThumbnailGenerator $thumbnailGenerator,
    ) {
    }

    public function generate(Image $image): Thumbnail
    {
        $imagePath = $image->path;

        try {
            $thumbnail = $this->thumbnailGenerator->generate(new ThumbnailGenerationRequest($imagePath));
        } catch (IOException | ImagickException $exception) {
            throw ThumbnailGenerationFailed::forThirtParty($imagePath, $exception);
        }

        $thumbnailName = $this->getThumbnailName($imagePath, $thumbnail->extension);

        return new Thumbnail($thumbnail->blob, $thumbnailName);
    }

    private function getThumbnailName(string $imagePath, string $extension): string
    {
        $trailingName = basename($imagePath);
        return  Path::getFilenameWithoutExtension($trailingName) . '.' . $extension;
    }
}
