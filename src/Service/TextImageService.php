<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\Service;

use Carbon\Carbon;
use Intervention\Image\Gd\Font as GdFont;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Mo3golom\WonderStories\DTO\Font;
use Mo3golom\WonderStories\Factory\FileSystemFactory;

class TextImageService
{
    private const MAX_LINE_LENGTH = 45;

    private int $offset;

    private Font $font;

    private array $lines = [];

    private Image $canvas;

    public function __construct(
        private ImageManager $imageManager,
        private FileSystemFactory $fileSystemFactory
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

    public function generate(?int $width = null, ?int $height = null): TextImageService
    {
        $y = $this->offset + ($this->font->getSize() / 2);

        $this->canvas = $this->imageManager->canvas($width ?? 1, $height ?? 1);

        $calcWidth = 0;

        foreach ($this->lines as $i => $line) {
            $this->canvas->text($line, $this->offset, $y, function (GdFont $font) use (&$calcWidth) {
                $font->file($this->font->getPath());
                $font->size($this->font->getSize());
                $font->color($this->font->getColor());

                $size = $font->getBoxSize();
                $calcWidth = $calcWidth < $size['width'] ? $size['width'] : $calcWidth;
            });

            // Магическая формула, вычисленная эмпирическим путем
            $y += ($this->font->getSize() - ($this->font->getSize() / 7));
        }

        // Если не была задана ширина и высота изображения, то пересоздаем изображение с подсчитанными размерами
        if (null === $width && null === $height) {
            return $this->generate($calcWidth + $this->offset * 2, (int)$y);
        }

        return $this;
    }

    public function get(): Image
    {
        return $this->canvas;
    }

    public function save(string $disk = 'public', ?string $filename = null, string $format = 'png'): string
    {
        $now = Carbon::now();
        $path = sprintf(
            '%s/%s/%s/%s.png',
            $now->year,
            $now->month,
            $now->day,
            $filename ?? "text_image_{$now->format('dmYHis')}"
        );

        $this->fileSystemFactory->adapter('local')->write($path, (string)$this->canvas->encode($format, 100));

        return $path;
    }
}
