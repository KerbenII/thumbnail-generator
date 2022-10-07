<?php

declare(strict_types=1);

namespace App\Thumbnail\Integration\Symfony\Command;

use App\Storage\Api\Input\File;
use App\Storage\Api\UploadApi;
use App\Thumbnail\Api\Input\Image;
use App\Thumbnail\Api\ThumbnailApi;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class GenerateThumbnailCommand extends Command
{
    protected static $defaultName = 'thumbnail:generate';

    public function __construct(private readonly ThumbnailApi $thumbnailApi, private readonly UploadApi $uploadApi)
    {
        parent::__construct(self::$defaultName);
    }

    protected function configure(): void
    {
        $this->addArgument(
            'pathToImage',
            InputArgument::REQUIRED,
            'For what image should we generate thumbnail?'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        //TODO: Should pass through the Storage module.
        $pathToImage = $input->getArgument('pathToImage');
        $thumbnail = $this->thumbnailApi->generate(new Image($pathToImage));

        $uploadedFile = $this->uploadApi->uploadFile(new File(
            $thumbnail->blob,
            $thumbnail->fileName
        ));

        $output->writeln($uploadedFile->path);


        return Command::SUCCESS;
    }
}
