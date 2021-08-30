<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\DTO;

class Block
{
    private Type $type;

    private float $duration;

    private float $startAt;

    private Position $position;

    /**
     * @var BlockFrame[]
     */
    private array $frames = [];

    public function getType(): Type
    {
        return $this->type;
    }

    public function setType(Type $type): Block
    {
        $this->type = $type;

        return $this;
    }

    public function getDuration(): float
    {
        return $this->duration;
    }

    public function setDuration(float $duration): Block
    {
        $this->duration = $duration;

        return $this;
    }

    public function getStartAt(): float
    {
        return $this->startAt;
    }

    public function setStartAt(float $startAt): Block
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getPosition(): Position
    {
        return $this->position;
    }

    public function setPosition(Position $position): Block
    {
        $this->position = $position;

        return $this;
    }

    public function getFrames(): array
    {
        return $this->frames;
    }

    /**
     * @param BlockFrame[] $frames
     *
     * @return $this
     */
    public function setFrames(array $frames): Block
    {
        $this->frames = $frames;

        return $this;
    }
}
