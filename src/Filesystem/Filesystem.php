<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\Filesystem;

use League\Flysystem\FilesystemAdapter;
use League\Flysystem\PathNormalizer;

class Filesystem extends \League\Flysystem\Filesystem
{
    private FilesystemAdapter $adapter;

    public function __construct(
        FilesystemAdapter $adapter,
        array $config = [],
        PathNormalizer $pathNormalizer = null
    ) {
        $this->adapter = $adapter;

        parent::__construct($adapter, $config, $pathNormalizer);
    }

    public function getFullPath(string $path): string
    {
        if (method_exists($this->adapter, 'getFullPath')) {
            return $this->adapter->getFullPath($path);
        }

        return $path;
    }
}
