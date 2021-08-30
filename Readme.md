# Wonder Stories

---
Сервис, созданные для генерации видео креативов для instagram stroies / reels или тик-ток видео

---
Требования:

- php:8.0
- ffmpeg
- gd
- imagick

---

## Установка

Вы можете установить пакет с помощью composer:

```bash
composer require mo3golom/wonder-stories
```

## Использование

Базовое использование:
```php
$background = (new \Mo3golom\WonderStories\DTO\Background())
    ->setWidth(576)
    ->setHeight(1024)
    ->setDuration(7)
    ->setPath('path_to_mp4_video')
;

$block =  (new \Mo3golom\WonderStories\DTO\Block())
        ->setType(
            (new \Mo3golom\WonderStories\DTO\Type())
                ->setId(\Mo3golom\WonderStories\Enum\BlockTypes::TYPE_TEXT)
                ->setSettings([
                    'text' => 'test',
                    'font_color' => '#ffffff',
                    'font_size' => 32,
                    'offset' => 16,
                    'background_enable' => true,
                    'background_color' => '#000000',
                ])
        )
        ->setDuration(5)
        ->setStartAt(0)
        ->setPosition(
            (new \Mo3golom\WonderStories\DTO\Position())
                ->setX(100)
                ->setY(100)
        )
    ;

$creative = (new \Mo3golom\WonderStories\DTO\Creative())
    ->setBlocks([$block])
    ->setBackground($background)
;

$wonderStories = \Mo3golom\WonderStories\Service\WonderStories::make();
echo $wonderStories->createFromCreative($creative);
```


###Типы Блоков:

Есть несколько доступных типов блоков (устанавливается в DTO Type, метод setId)

- \Mo3golom\WonderStories\Enum\BlockTypes::TYPE_TEXT - обычный многострочный текст. Имеет следующие настройки:
```php
[
    'text' => 'test', // отображаемый текст
    'font_color' => '#ffffff', // цвет текста в HEX формате
    'font_size' => 32, // размер текста
    'font_path' => 'path_to_font.ttf', // путь до файла шрифта .ttf
    'offset' => 16, // отступ от краев фона (будет заметно, если отрисовать фон)
    'background_enable' => true, // включить отрисовку фона
    'background_color' => '#000000', // цвет фона
]
```

- \Mo3golom\WonderStories\Enum\BlockTypes::TYPE_TIMER - таймер обратного отсчета. Стартовое число зависит от продолжительности блока (setDuration). Имеет следующие настройки:
```php
[
    'font_color' => '#ffffff', // цвет текста в HEX формате
    'font_size' => 32, // размер текста
    'font_path' => 'path_to_font.ttf', // путь до файла шрифта .ttf
    'offset' => 16, // отступ от краев фона (будет заметно, если отрисовать фон)
    'background_enable' => true, // включить отрисовку фона
    'background_color' => '#000000', // цвет фона
]
```
