<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\DTO;

class Timing
{
    private float $startAt;

    private float $duration;

    public function getStartAt(): float
    {
        return $this->startAt;
    }

    public function setStartAt(float $startAt): Timing
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getDuration(): float
    {
        return $this->duration;
    }

    public function setDuration(float $duration): Timing
    {
        $this->duration = $duration;

        return $this;
    }
}
