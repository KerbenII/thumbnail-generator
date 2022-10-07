<?php

declare(strict_types=1);

namespace App\Storage\Api;

use App\Storage\Api\Input as Input;
use App\Storage\Api\Output as Output;
use App\Storage\Api\Output\DirectoryContent;
use App\Storage\Main\Exception\StorageException;
use App\Storage\Main\LocalPath;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;

final class DownloadApiFlysystem implements DownloadApi
{
    public function __construct(
        private readonly FilesystemOperator $imagesFilesystem,
        private readonly LocalPath $localPath
    ) {
    }

    /**
     * @throws StorageException
     */
    public function iterateDirectory(Input\Path $path): DirectoryContent
    {
        try {
            $files = $this->imagesFilesystem->listContents($path->path);
        } catch (FilesystemException $exception) {
            throw StorageException::forDownload($path->path, $exception);
        }

        $paths = [];
        foreach ($files as $file) {
            $paths[] = new Output\Path(
                $this->localPath->getAbsolutePath($file->path())
            );
        }

        return new DirectoryContent($paths);
    }
}
