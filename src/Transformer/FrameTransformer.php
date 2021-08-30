<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\Transformer;

class FrameTransformer
{
    public const FRAMES_PER_SECOND = 24;

    public static function secondsToFrameCount(float $seconds, int $framesPerSecond = self::FRAMES_PER_SECOND): int
    {
        return (int) $seconds * $framesPerSecond;
    }

    public static function frameCountToSeconds(int $frameCount, int $framesPerSecond = self::FRAMES_PER_SECOND): float
    {
        return $frameCount / $framesPerSecond;
    }
}
