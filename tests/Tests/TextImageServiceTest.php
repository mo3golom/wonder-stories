<?php

declare(strict_types=1);

use Intervention\Image\ImageManager;
use Mo3golom\WonderStories\DTO\Font;
use Mo3golom\WonderStories\Factory\FileSystemFactory;
use Mo3golom\WonderStories\Service\TextImageService;
use PHPUnit\Framework\TestCase;

class TextImageServiceTest extends TestCase
{
    public function testGenerateImage(): void
    {
        $service = new TextImageService(
            new ImageManager(),
            new FileSystemFactory()
        );

        $font = (new Font())
            ->setColor('#000000')
            ->setSize(16)
        ;

        $service
            ->setFont($font)
            ->setOffset(4)
            ->setText('Шышел мышел взял да вышел')
            ->generate()
            ->save()
        ;
    }
}
