<?php

declare(strict_types=1);

namespace App\Storage\Api;

use App\Storage\Api\Input\Path;
use App\Storage\Api\Output\DirectoryContent;

interface DownloadApi
{
    public function iterateDirectory(Path $path): DirectoryContent;
}
