<?php

declare(strict_types=1);

namespace App\Storage\Main;

use Aws\S3\S3ClientInterface;

final class S3Path implements PathInterface
{
    public function __construct(
        private readonly string $bucket,
        private readonly S3ClientInterface $s3
    ) {
    }
    public function getAbsolutePath(string $fileName): string
    {
        return "https://{$this->bucket}.s3.{$this->s3->getRegion()}.amazonaws.com/$fileName";
    }
}
