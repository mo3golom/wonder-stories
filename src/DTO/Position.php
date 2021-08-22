<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\DTO;

class Position
{
    private int $x;

    private int $y;

    public function getX(): int
    {
        return $this->x;
    }

    public function setX(int $x): Position
    {
        $this->x = $x;

        return $this;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function setY(int $y): Position
    {
        $this->y = $y;

        return $this;
    }
}
