<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\DTO;

class Background
{
    private string $path;

    private int $width;

    private int $height;

    private int $duration;

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): Background
    {
        $this->path = $path;

        return $this;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): Background
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): Background
    {
        $this->height = $height;

        return $this;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): Background
    {
        $this->duration = $duration;

        return $this;
    }
}
