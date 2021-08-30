<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\Service;

use Mo3golom\WonderStories\Factory\FileSystemFactory;

class FrameCollectorService
{
    public function __construct(
        private FFmpegService $FFmpegService,
        private FileSystemFactory $fileSystemFactory,
        private string $adapter = 'local'
    ) {
    }

    public function collectFramesToVideo(
        array $frames,
        int $framerate = 24
    ): ?string {
        $tempDir = sprintf('frame_compose_%d', time());
        $disk = $this->fileSystemFactory->adapter($this->adapter);

        $pathPattern = $disk->getFullPath("{$tempDir}/%03d.png");

        $outputDir = 'frame_compose_result';
        $disk->createDir($outputDir);

        foreach ($frames as $i => $frame) {
            $path = sprintf(
                '%s/%s.png',
                $tempDir,
                str_pad((string) ((int) $i + 1), 3, "0", STR_PAD_LEFT)
            );

            $disk->write($path, (string) $frame->encode('png', 100));
        }

        $outputVideo = sprintf('%s/%d.mov', $disk->getFullPath($outputDir), time());
        $result = $this->FFmpegService->makeVideoFromImages(
            $pathPattern,
            $framerate,
            $outputVideo,
        );

        if ($result) {
            $disk->deleteDir($tempDir);

            return $outputVideo;
        }

        return null;
    }
}
