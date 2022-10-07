<?php

declare(strict_types=1);

namespace App\Storage\Api;

use App\Storage\Api\Input\File;
use App\Storage\Api\Output\UploadedFile;
use App\Storage\Main\Exception\StorageException;
use App\Storage\Main\S3Path;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;

final class UploadApiS3 implements UploadApi
{
    public function __construct(
        private readonly FilesystemOperator $s3Filesystem,
        private readonly S3Path $s3Path
    ) {
    }

    public function uploadFile(File $file): UploadedFile
    {
        try {
            $this->s3Filesystem->write(
                $file->fileName,
                $file->blob,
                [
                    'visibility' => 'public'
                ]
            );
        } catch (FilesystemException $exception) {
            throw StorageException::forUpload($file->fileName, $exception);
        }

        $url = $this->s3Path->getAbsolutePath($file->fileName);

        return new UploadedFile($url);
    }
}
