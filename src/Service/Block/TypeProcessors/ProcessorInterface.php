<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\Service\Block\TypeProcessors;

use Mo3golom\WonderStories\DTO\Block;
use Mo3golom\WonderStories\DTO\BlockFrame; // phpcs:ignore
use Mo3golom\WonderStories\Service\TextImageService;

interface ProcessorInterface
{
    public function __construct(TextImageService $textImageService);

    /**
     * @param Block $block
     * @param int $framesPerSecond
     * @return BlockFrame[]
     */
    public function processing(Block $block, int $framesPerSecond = 24): array;
}
