<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\Service\Types;

use Mo3golom\WonderStories\DTO\Type;

interface TypeInterface
{
    public function setType(Type $type): TypeInterface;
}
