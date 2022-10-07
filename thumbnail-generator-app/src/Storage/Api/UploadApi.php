<?php

declare(strict_types=1);

namespace App\Storage\Api;

use App\Storage\Api\Input\File;
use App\Storage\Api\Output\UploadedFile;

interface UploadApi
{
    public function uploadFile(File $file): UploadedFile;
}
