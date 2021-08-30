<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\Service;

use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Mo3golom\WonderStories\DTO\Block; // phpcs:ignore
use Mo3golom\WonderStories\DTO\BlockFrame; // phpcs:ignore
use Mo3golom\WonderStories\Service\Block\TypeBus;
use Mo3golom\WonderStories\Transformer\FrameTransformer;

class FrameService
{
    public function __construct(
        private TypeBus $typeBus,
        private ImageManager $imageManager
    ) {
    }

    /**
     * @param Block[] $blocks
     * @param int $width
     * @param int $height
     * @param int $duration
     * @param int $framerate
     * @return Image[]
     */
    public function createFrames(array $blocks, int $width, int $height, int $duration, int $framerate = 24): array
    {
        $frames = [];

        $blockFrames = $this->makeBlockFrames($blocks);

        $durationInFrames = FrameTransformer::secondsToFrameCount(
            $duration,
            $framerate
        );
        $framePos = 1;

        do {
            $frames[] = $this->createFrame(
                $width,
                $height,
                $blockFrames[$framePos] ?? []
            );

            $framePos++;
        } while ($framePos <= $durationInFrames);

        return $frames;
    }

    /**
     * @param int $width
     * @param int $height
     * @param BlockFrame[] $blockFrames
     *
     * @return \Intervention\Image\Image
     */
    private function createFrame(int $width, int $height, array $blockFrames): Image
    {
        $frame = $this->imageManager->canvas($width, $height);

        foreach ($blockFrames as $blockFrame) {
            $frame->insert(
                $blockFrame->getImage(),
                'top-left',
                $blockFrame->getPosition()->getX(),
                $blockFrame->getPosition()->getY(),
            );
        }

        return $frame;
    }

    private function makeBlockFrames(array $blocks): array
    {
        $frameSet = [];

        // @TODO подумать, как развернуть цикл в более плоский
        foreach ($blocks as $block) {
            $frames = $this->typeBus->handle($block);

            if (null === $frames) {
                continue;
            }

            foreach ($frames as $blockFrame) {
                [$framePosMin, $framePosMax] = $blockFrame->getFrameRange();

                // Если минимум вдруг больше, чем максимум, то меняем их местами
                if ($framePosMin > $framePosMax) {
                    $temp = $framePosMin;
                    $framePosMin = $framePosMax;
                    $framePosMax = $temp;
                }

                for ($framePos = $framePosMin; $framePos <= $framePosMax; $framePos++) {
                    $frameSet[$framePos][] = $blockFrame;
                }
            }
        }

        return $frameSet;
    }
}
