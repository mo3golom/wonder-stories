<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\Service\Block\TypeProcessors;

use Mo3golom\WonderStories\Service\TextImageService;

abstract class AbstractProcessor implements ProcessorInterface
{
    public function __construct(
        protected TextImageService $textImageService
    ) {
    }
}
