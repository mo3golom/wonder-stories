<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\Filesystem;

class Filesystem extends \League\Flysystem\Filesystem
{
    public function getFullPath(string $path): string
    {
        return $this->adapter->applyPathPrefix($path);
    }
}
