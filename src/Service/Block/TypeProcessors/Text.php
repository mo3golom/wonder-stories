<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\Service\Block\TypeProcessors;

use Mo3golom\WonderStories\DTO\Block;
use Mo3golom\WonderStories\DTO\BlockFrame;
use Mo3golom\WonderStories\DTO\Font;
use Mo3golom\WonderStories\Transformer\FrameTransformer;

class Text extends AbstractProcessor
{
    /**
     * @param \Mo3golom\WonderStories\DTO\Block $block
     * @param int $framesPerSecond
     * @return BlockFrame[]
     */
    public function processing(Block $block, int $framesPerSecond = 24): array
    {
        $settings = $block->getType()->getSettings();

        $font = new Font();
        $font
            ->setSize($settings['font_size'] ?? 24)
            ->setColor($settings['font_color'] ?? '#000000')
        ;

        if (array_key_exists('font_path', $settings)) {
            $font->setPath($settings['font_path']);
        }

        $textImage = $this->textImageService
            ->setFont($font)
            ->setOffset((int) ($settings['offset'] ?? 4))
            ->setText($settings['text'])
            ->setWithBackground($settings['background_enable'] ?? false)
            ->setBackgroundColor($settings['background_color'] ?? '')
            ->generate()
        ;

        // Теперь необходимо распределить по кадрам на всю продолжительность текста
        $frameStartPos = FrameTransformer::secondsToFrameCount($block->getStartAt(), $framesPerSecond);
        $frameEndPos = FrameTransformer::secondsToFrameCount($block->getStartAt() + $block->getDuration(), $framesPerSecond) - 1;

        return [
            (new BlockFrame())
                ->setPosition($block->getPosition())
                ->setFrameMin($frameStartPos)
                ->setFrameMax($frameEndPos)
                ->setImage($textImage),
        ];
    }
}
