<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\DTO;

use Mo3golom\WonderStories\Helper\KernelHelper;

class Font
{
    private int $size = 24;

    private string $path;

    private string $color = '#000000';

    public function __construct()
    {
        // Шрифт по умолчанию
        $this->path = KernelHelper::getProjectDir() . '/resources/fonts/Roboto-Regular.ttf';
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize(int $size): Font
    {
        $this->size = $size;

        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): Font
    {
        $this->path = $path;

        return $this;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): Font
    {
        $this->color = $color;

        return $this;
    }
}
