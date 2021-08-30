<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\Service;

use Intervention\Image\ImageManager;
use Mo3golom\WonderStories\DTO\Creative;
use Mo3golom\WonderStories\Factory\FileSystemFactory;
use Mo3golom\WonderStories\Service\Block\TypeBus;

class WonderStories
{
    private int $framerate = 24;

    private string $errors = '';

    public function __construct(
        private FrameService $frameService,
        private FrameCollectorService $frameCollectorService,
        private VideoCollectorService $videoCollectorService,
        private FileSystemFactory $fileSystemFactory
    ) {
    }

    public function createFromCreative(Creative $creative): ?string
    {
        $this->errors = '';

        try {
            $adapter = 'local';
            $disk = $this->fileSystemFactory->adapter($adapter);

            $frames = $this->frameService->createFrames(
                $creative->getBlocks(),
                $creative->getBackground()->getWidth(),
                $creative->getBackground()->getHeight(),
                $creative->getBackground()->getDuration(),
                $this->framerate
            );

            $frameVideo = $this->frameCollectorService->collectFramesToVideo($frames);

            if (null === $frameVideo) {
                return null;
            }

            $outputDir = 'final_video';
            $disk->createDirectory($outputDir);
            $output = sprintf(
                '%s/final_%s.mp4',
                $disk->getFullPath($outputDir),
                time()
            );

            $this->videoCollectorService->collect(
                $creative->getBackground(),
                $frameVideo,
                $output
            );

            return $output;
        } catch (\Throwable $th) {
            $this->errors = $th->getMessage();
        }

        return null;
    }

    public function setFramerate(int $framerate): WonderStories
    {
        $this->framerate = $framerate;

        return $this;
    }

    public function getErrors(): string
    {
        return $this->errors;
    }

    public static function make(?array $config = null): WonderStories
    {
        $imageManager = new ImageManager();
        $filesystemFactory = new FileSystemFactory($config['filesystem'] ?? null);

        return new WonderStories(
            new FrameService(
                new TypeBus(
                    new TextImageService($imageManager),
                    $config['block_types'] ?? null
                ),
                $imageManager
            ),
            new FrameCollectorService(
                new FFmpegService(),
                $filesystemFactory
            ),
            new VideoCollectorService(),
            $filesystemFactory
        );
    }
}
