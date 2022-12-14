<?php

declare(strict_types=1);

namespace App\Thumbnail\Integration\Symfony\Command;

use App\Storage\Api\DownloadApi;
use App\Storage\Api\Input\File;
use App\Storage\Api\Input\Path;
use App\Storage\Api\UploadApi;
use App\Storage\Main\Exception\StorageException;
use App\Thumbnail\Api\Input\Image;
use App\Thumbnail\Api\ThumbnailApi;
use App\Thumbnail\Main\Application\Exception\ThumbnailGenerationFailed;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class GenerateThumbnailsFromDirectoryCommand extends Command
{
    protected static $defaultName = 'thumbnail:generate-many';

    public function __construct(
        private readonly ThumbnailApi $thumbnailApi,
        private readonly UploadApi $uploadApi,
        private readonly DownloadApi $downloadApi
    ) {
        parent::__construct(self::$defaultName);
    }

    protected function configure(): void
    {
        $this->addArgument(
            'pathToDirectory',
            InputArgument::REQUIRED,
            'For what directory should we generate thumbnails?'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $pathToDirectory = $input->getArgument('pathToDirectory');
        $directoryContent = $this->downloadApi->iterateDirectory(new Path($pathToDirectory));

        $progressBar = new ProgressBar(
            $output,
            count($directoryContent->paths)
        );

        foreach ($directoryContent->paths as $path) {
            $progressBar->advance();
            try {
                $thumbnail = $this->thumbnailApi->generate(new Image($path->path));

                $uploadedFile = $this->uploadApi->uploadFile(new File(
                    $thumbnail->blob,
                    $thumbnail->fileName
                ));

                $output->writeln($uploadedFile->path);
            } catch (ThumbnailGenerationFailed | StorageException $exception) {
                $output->writeln(sprintf(
                    '<error>%s</error>',
                    $exception->getMessage()
                ));
            }
        }

        $progressBar->finish();

        return Command::SUCCESS;
    }
}
