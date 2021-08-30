<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\Filesystem;

use League\Flysystem\PathPrefixer;
use League\Flysystem\UnixVisibility\VisibilityConverter;
use League\MimeTypeDetection\MimeTypeDetector;

class LocalFilesystemAdapter extends \League\Flysystem\Local\LocalFilesystemAdapter
{
    private PathPrefixer $prefixer;

    public function __construct(
        string $location,
        VisibilityConverter $visibility = null,
        int $writeFlags = LOCK_EX,
        int $linkHandling = \League\Flysystem\Local\LocalFilesystemAdapter::DISALLOW_LINKS,
        MimeTypeDetector $mimeTypeDetector = null
    ) {
        $this->prefixer = new PathPrefixer($location, DIRECTORY_SEPARATOR);

        parent::__construct($location, $visibility, $writeFlags, $linkHandling, $mimeTypeDetector);
    }

    public function getFullPath(string $path): string
    {
        return $this->prefixer->prefixPath($path);
    }
}
