<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\Service;

use FFMpeg\Coordinate\Dimension;
use FFMpeg\Coordinate\Point;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Format\Video\X264;
use Mo3golom\WonderStories\DTO\Background;
use Mo3golom\WonderStories\Exception\InvalidResizeDimensionVideoException;

class VideoCollectorService
{
    private FFMpeg $ffmpeg;

    public function __construct()
    {
        $this->ffmpeg = FFMpeg::create();
    }

    /**
     * @param \Mo3golom\WonderStories\DTO\Background $backgroundVideo
     * @param string $frameVideoPath
     * @param string $outputPath
     * @return bool
     *
     * @throws \Mo3golom\WonderStories\Exception\InvalidResizeDimensionVideoException
     *
     * @psalm-suppress PossiblyUndefinedMethod
     */
    public function collect(
        Background $backgroundVideo,
        string $frameVideoPath,
        string $outputPath
    ): bool {
        $backgroundSize = $this->getDimension($backgroundVideo->getPath());
        $backgroundSizeNew = new Dimension($backgroundVideo->getWidth(), $backgroundVideo->getHeight());

        if (null === $backgroundSize) {
            throw new InvalidResizeDimensionVideoException('Не удалось получить размеры из видео для дальнейшей обрезки');
        }

        if (
            $backgroundSizeNew->getWidth() > $backgroundSize->getWidth()
            || $backgroundSizeNew->getHeight() > $backgroundSize->getHeight()
        ) {
            throw new InvalidResizeDimensionVideoException('Размеры обрезки больше чем размеры исходного видео');
        }

        $centerX = ($backgroundSize->getWidth() / 2) - ($backgroundSizeNew->getWidth() / 2);
        $centerY = ($backgroundSize->getHeight() / 2) - ($backgroundSizeNew->getHeight() / 2);

        $video = $this->ffmpeg
            ->open($backgroundVideo->getPath())
            ->clip(TimeCode::fromSeconds(0), TimeCode::fromSeconds($backgroundVideo->getDuration()))
        ;

        $pathInfo = pathinfo($outputPath);

        if (!array_key_exists('extension', $pathInfo)) {
            throw new InvalidResizeDimensionVideoException('Не удалось получить расширение файла для сохранения');
        }

        $tempOutputPath = str_replace('.' . $pathInfo['extension'], '_temp.' . $pathInfo['extension'], $outputPath);
        $video
            ->filters()
            ->crop(new Point($centerX, $centerY), $backgroundSizeNew)
        ;
        $video->save(new X264(), $tempOutputPath);

        // Делаем так, т.к. одновременно обрезать и вставить вотермарку нельзя
        /** @var \FFMpeg\Media\AbstractVideo $finalVideo */
        $finalVideo = $this->ffmpeg->open($tempOutputPath);
        $finalVideo
            ->filters()
            ->watermark(
                $frameVideoPath,
                [
                    'position' => 'relative',
                    'left' => 0,
                    'top' => 0,
                ]
            )
        ;

        $finalVideo->save(new X264(), $outputPath);
        unlink($tempOutputPath);
        unlink($frameVideoPath);

        return true;
    }

    private function getDimension(string $path): ?Dimension
    {
        $video = FFProbe::create()
                        ->streams($path)
                        ->videos()
                        ->first()
        ;

        if (null !== $video) {
            return $video->getDimensions();
        }

        return null;
    }
}
