<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\DTO;

class Block
{
    private Type $type;

    private Timing $timing;

    private Position $position;

    public function getType(): Type
    {
        return $this->type;
    }

    public function setType(Type $type): Block
    {
        $this->type = $type;

        return $this;
    }

    public function getTiming(): Timing
    {
        return $this->timing;
    }

    public function setTiming(Timing $timing): Block
    {
        $this->timing = $timing;

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
}
