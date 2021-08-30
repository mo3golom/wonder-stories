<?php

declare(strict_types=1);

use Mo3golom\WonderStories\Enum\BlockTypes;
use Mo3golom\WonderStories\Service\Block\TypeProcessors\Text;
use Mo3golom\WonderStories\Service\Block\TypeProcessors\Timer;

return [
    BlockTypes::TYPE_TEXT => [
        'id' => BlockTypes::TYPE_TEXT,
        'name' => 'Текст',
        'processor' => Text::class,
    ],
    BlockTypes::TYPE_TIMER => [
        'id' => BlockTypes::TYPE_TIMER,
        'name' => 'Таймер',
        'processor' => Timer::class,
    ],
];