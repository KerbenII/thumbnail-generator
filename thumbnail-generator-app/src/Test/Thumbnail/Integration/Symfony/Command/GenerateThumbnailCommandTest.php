<?php

declare(strict_types=1);

namespace App\Test\Thumbnail\Integration\Symfony\Command;

use App\Storage\Api\UploadApi;
use App\Storage\Main\S3Path;
use App\Thumbnail\Api\ThumbnailApi;
use App\Thumbnail\Integration\Symfony\Command\GenerateThumbnailCommand;
use App\Thumbnail\Main\Application\ThumbnailFormatExtension;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

final class GenerateThumbnailCommandTest extends KernelTestCase
{
    private ?CommandTester $commandTester;
    private ?ThumbnailFormatExtension $thumbnailFormatExtension;
    private ?S3Path $s3Path;
    private ?int $maximumLength;

    protected function setUp(): void
    {
        $application = new Application();
        self::bootKernel();
        $container = self::getContainer();

        $this->thumbnailFormatExtension = new ThumbnailFormatExtension($_ENV['THUMBNAIL_FORMAT']);
        $this->maximumLength = (int)$_ENV['THUMBNAIL_MAXIMUM_LENGTH'];

        /** @var S3Path $s3Path */
        $s3Path = $container->get(S3Path::class);
        $this->s3Path = $s3Path;

        /** @var ThumbnailApi $thumbnailApi */
        $thumbnailApi = $container->get(ThumbnailApi::class);
        /** @var UploadApi $uploadApi */
        $uploadApi = $container->get(UploadApi::class);

        $application->add(new GenerateThumbnailCommand(
            $thumbnailApi,
            $uploadApi
        ));

        $command = $application->find('thumbnail:generate');
        $this->commandTester = new CommandTester($command);
    }

    protected function tearDown(): void
    {
        $this->commandTester = null;
        $this->thumbnailFormatExtension = null;
        $this->s3Path = null;
        $this->maximumLength = null;
    }

    /**
     * @dataProvider pathes
     */
    public function testExecute(string $path)
    {

        $this->commandTester->execute(['pathToImage' => $path]);
        $this->assertEquals(Command::SUCCESS, $this->commandTester->getStatusCode());

        [$filename] = explode('.', basename($path));

        $absolutePath = $this->s3Path->getAbsolutePath($filename . '.' . $this->thumbnailFormatExtension->extension());

        $imageSize = $this->getImageSize($absolutePath);

        $this->assertNotFalse($imageSize);

        $this->assertLessThanOrEqual($this->maximumLength, $imageSize[0]);
        $this->assertLessThanOrEqual($this->maximumLength, $imageSize[1]);
    }

    public function pathes(): \Generator
    {
        yield ['images/1.jpg'];
        yield ['images/2.png'];
    }

    private function getImageSize(string $absolutePath): array|false
    {
        $temp = tmpfile();
        $path = stream_get_meta_data($temp)['uri'];
        fwrite($temp, file_get_contents($absolutePath));
        $imageSize = getimagesize($path);
        fclose($temp);
        return $imageSize;
    }
}
