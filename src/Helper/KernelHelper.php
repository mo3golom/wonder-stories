<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\Helper;

class KernelHelper
{
    /**
     * Статик обертка
     */
    public static function getProjectDir(): string
    {
        return (new self())->getProjectDirNonStatic();
    }

    /**
     * Метод для нахождения корневой папки проекта
     */
    private function getProjectDirNonStatic(): string
    {
        $r = new \ReflectionObject($this);

        $dir = $r->getFileName();
        $dir = \dirname($dir);

        while (!is_file($dir . '/composer.json')) {
            $dir = \dirname($dir);
        }

        return $dir;
    }
}
