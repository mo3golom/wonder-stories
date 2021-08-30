<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\Service\Block;

use Mo3golom\WonderStories\DTO\Block;
use Mo3golom\WonderStories\Enum\BlockTypes;
use Mo3golom\WonderStories\Service\TextImageService;

/**
 * Класс, который собирает цепочку процессоров
 * И отдает ей на обработку блок
 *
 * Class TypeBus
 */
class TypeBus
{
    private ?TypeHandler $typeHandler = null;

    public function __construct(
        TextImageService $textImageService,
        ?array $config = null
    ) {
        $blockTypes = new BlockTypes($config);

        $this->buildHandlers($textImageService, $blockTypes);
    }

    /**
     * Метод обработки блока цепочкой
     *
     * @param \Mo3golom\WonderStories\DTO\Block $block
     * @param int $framesPerSecond
     * @return array|null
     */
    public function handle(Block $block, int $framesPerSecond = 24): ?array
    {
        if (null === $this->typeHandler) {
            return null;
        }

        return $this->typeHandler->handle($block, $framesPerSecond);
    }

    /**
     * Метод сборки цепочки процессоров
     *
     * @param \Mo3golom\WonderStories\Service\TextImageService $textImageService
     * @param \Mo3golom\WonderStories\Enum\BlockTypes $blockTypes
     */
    private function buildHandlers(TextImageService $textImageService, BlockTypes $blockTypes): void
    {
        $prevHandler = null;

        foreach ($blockTypes->getTypes() as $handlerConfig) {
            $handler = new TypeHandler(
                $handlerConfig['id'],
                $handlerConfig['processor'],
                $textImageService
            );

            if (null !== $prevHandler) {
                $handler->setNext($prevHandler);
            }

            $prevHandler = clone $handler;
            unset($handler);
        }

        $this->typeHandler = $prevHandler;
    }
}
