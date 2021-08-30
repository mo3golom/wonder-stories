<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\DTO;

use Intervention\Image\Image;

class BlockFrame
{
    private Position $position;

    private int $frameMin;

    private int $frameMax;

    private Image $image;

    public function getPosition(): Position
    {
        return $this->position;
    }

    public function setPosition(Position $position): BlockFrame
    {
        $this->position = $position;

        return $this;
    }

    public function getFrameRange(): array
    {
        return [$this->frameMin, $this->frameMax];
    }

    public function setFrameMin(int $frameMin): BlockFrame
    {
        $this->frameMin = $frameMin;

        return $this;
    }

    public function setFrameMax(int $frameMax): BlockFrame
    {
        $this->frameMax = $frameMax;

        return $this;
    }

    public function getImage(): Image
    {
        return $this->image;
    }

    public function setImage(Image $image): BlockFrame
    {
        $this->image = $image;

        return $this;
    }
}
