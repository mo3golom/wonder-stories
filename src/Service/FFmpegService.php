<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\Service;

//ffmpeg -framerate 24 -i %03d.png -vcodec png  output.mov
class FFmpegService
{
    private const SUCCESS_EXIT_STATUS = 0;

    private array $execOutput = [];

    /**
     * @param string $inputPattern - путь паттерн до изображений (пример: %03d.png для 001.png, 002.png и т.д.)
     * @param int $framerate - сколько кадров в секунду
     * @param string $output - путь до видео, которое будет создано
     * @param string $vCodec
     * @return bool
     */
    public function makeVideoFromImages(string $inputPattern, int $framerate, string $output, string $vCodec = 'png'): bool
    {
        $command = sprintf(
            '-framerate %d -i %s -vcodec %s %s',
            $framerate,
            $inputPattern,
            $vCodec,
            $output
        );

        return $this->execFFmpeg($command);
    }

    public function getOutput(): array
    {
        return $this->execOutput;
    }

    private function execFFmpeg(string $command): bool
    {
        $exitStatus = 0;
        $this->execOutput = [];

        exec(
            sprintf('ffmpeg %s 2>&1 >/dev/null', $command),
            $this->execOutput,
            $exitStatus
        );

        return self::SUCCESS_EXIT_STATUS === $exitStatus;
    }
}
