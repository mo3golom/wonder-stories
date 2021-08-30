<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\Enum;

use Mo3golom\WonderStories\Helper\KernelHelper;

class BlockTypes
{
    public const TYPE_TEXT = 'text';

    public const TYPE_TIMER = 'timer';

    private array $config;

    /**
     * BlockTypes constructor.
     *
     * @param array|null $config
     *
     * @psalm-suppress UnresolvableInclude
     */
    public function __construct(?array $config = null)
    {
        $this->config = $config ?? require(KernelHelper::getProjectDir() . '/config/block_types.php');
    }

    public function getTypes(): array
    {
        return $this->config;
    }
}
