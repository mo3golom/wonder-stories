<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\DTO;

class Font
{
    private int $size;

    private string $path = __DIR__ . '/../../resources/fonts/Roboto-Regular.ttf';

    private string $color;

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
