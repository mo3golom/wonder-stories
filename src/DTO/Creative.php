<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\DTO;

class Creative
{
    /**
     * @var Block[]
     */
    private array $blocks;

    private Background $background;

    public function getBlocks(): array
    {
        return $this->blocks;
    }

    /**
     * @param Block[] $blocks
     * @return $this
     */
    public function setBlocks(array $blocks): Creative
    {
        $this->blocks = $blocks;

        return $this;
    }

    public function getBackground(): Background
    {
        return $this->background;
    }

    public function setBackground(Background $background): Creative
    {
        $this->background = $background;

        return $this;
    }
}
