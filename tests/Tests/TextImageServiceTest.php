<?php

declare(strict_types=1);

use FFMpeg\FFMpeg;
use Intervention\Image\ImageManager;
use Mo3golom\WonderStories\DTO\Block;
use Mo3golom\WonderStories\DTO\Creative;
use Mo3golom\WonderStories\DTO\Font;
use Mo3golom\WonderStories\DTO\Position;
use Mo3golom\WonderStories\DTO\Timing;
use Mo3golom\WonderStories\DTO\Type;
use Mo3golom\WonderStories\Factory\FileSystemFactory;
use Mo3golom\WonderStories\Service\ImageService;
use Mo3golom\WonderStories\Service\TextImageService;
use PHPUnit\Framework\TestCase;

class TextImageServiceTest extends TestCase
{
    public function testGenerateImage(): void
    {
        $block = (new Block())
            ->setType(
                (new Type())
                    ->setId('text')
                    ->setSettings(['text' => 'загадка о двух стульях'])
            )
            ->setTiming(
                (new Timing())
                    ->setDuration(5)
                    ->setStartAt(0)
            )
            ->setPosition(
                (new Position())
                    ->setX(100)
                    ->setY(100)
            )
        ;

        $service = new TextImageService(
            new ImageManager(),
            new FileSystemFactory()
        );

        $typeBus = new \Mo3golom\WonderStories\Service\Block\TypeBus($service);

        $typeBus->handle($block);

        dd($block->getFrame());
    }
}
