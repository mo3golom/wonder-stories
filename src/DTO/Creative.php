<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\DTO;

class Creative
{
    /**
     * @var Block[]
     */
    private array $blocks;

    public function getBlocks(): array
    {
        return $this->blocks;
    }

    public function setBlocks(array $blocks): Creative
    {
        $this->blocks = $blocks;

        return $this;
    }
}
