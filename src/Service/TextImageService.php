<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\Service;

use Intervention\Image\Gd\Font as GdFont;
use Intervention\Image\Gd\Shapes\RectangleShape;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Mo3golom\WonderStories\DTO\Font;

/**
 * Class TextImageService
 */
class TextImageService
{
    private const MAX_LINE_LENGTH = 45;

    private int $offset = 4;

    private ?Font $font = null;

    private array $lines = [];

    private bool $withBackground = false;

    private string $backgroundColor = '#ff0000';

    public function __construct(
        private ImageManager $imageManager
    ) {
    }

    public function setText(string $text): TextImageService
    {
        $this->lines = explode("\n", wordwrap($text, self::MAX_LINE_LENGTH));

        return $this;
    }

    public function setOffset(int $offset): TextImageService
    {
        $this->offset = $offset;

        return $this;
    }

    public function setFont(Font $font): TextImageService
    {
        $this->font = $font;

        return $this;
    }

    public function setWithBackground(bool $withBackground): TextImageService
    {
        $this->withBackground = $withBackground;

        return $this;
    }

    public function setBackgroundColor(string $backgroundColor): TextImageService
    {
        $this->backgroundColor = $backgroundColor;

        return $this;
    }

    public function generate(): Image
    {
        $calcWidth = 1;
        $calcHeight = 0;

        $fonts = [];
        $y = $this->offset;

        foreach ($this->lines as $i => $line) {
            $font = new GdFont($line);

            if (null !== $this->font) {
                $font->file($this->font->getPath());
                $font->size($this->font->getSize());
                $font->color($this->font->getColor());
            }

            $fonts[$i] = [
                'font' => $font,
                'posX' => 0,
                'posY' => 0,
            ];

            // Из-за особенностей реализации шрифта в библиотеке
            // Нельзя установить align или valign, поэтому приходится использовать кое какой костыль
            $box = $font->getBoxSize();
            $fonts[$i]['posX'] = $this->offset - $box[6];
            $fonts[$i]['posY'] = $y - $box[7];

            $calcWidth = $calcWidth < $box['width'] ? $box['width'] : $calcWidth;
            $calcHeight += $box['height'] + $this->offset;
            $y += $box['height'] + $this->offset;
        }

        $calcWidth += $this->offset * 2;
        $calcHeight += $this->offset;
        $canvas = $this->imageManager->canvas($calcWidth, $calcHeight);

        // Рисуем подложку, только если была включена опция
        // и передана ширина и высота
        if ($this->withBackground) {
            $canvas->rectangle(
                0,
                0,
                $calcWidth,
                $calcHeight,
                function (RectangleShape $shape) {
                    $shape->background($this->backgroundColor);
                }
            );
        }

        foreach ($fonts as $font) {
            $font['font']->applyToImage(
                $canvas,
                $font['posX'],
                $font['posY']
            );
        }

        return $canvas;
    }
}
