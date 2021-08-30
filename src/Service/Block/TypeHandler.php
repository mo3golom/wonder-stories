<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\Service\Block;

use Mo3golom\WonderStories\DTO\Block;
use Mo3golom\WonderStories\Service\Block\TypeProcessors\ProcessorInterface;
use Mo3golom\WonderStories\Service\TextImageService;

class TypeHandler
{
    private ?TypeHandler $nextHandler = null;

    private ProcessorInterface $processor;

    /**
     * TypeHandler constructor.
     *
     * @param string $id
     * @param string $processorClass
     * @param \Mo3golom\WonderStories\Service\TextImageService $textImageService
     *
     * @psalm-suppress PropertyTypeCoercion
     */
    public function __construct(
        private string $id,
        string $processorClass,
        TextImageService $textImageService
    ) {
        $this->processor = new $processorClass($textImageService);
    }

    public function setNext(TypeHandler $typeHandler): TypeHandler
    {
        $this->nextHandler = $typeHandler;

        return $this;
    }

    public function handle(Block $block, int $framesPerSecond = 24): ?array
    {
        if ($block->getType()->getId() === $this->id) {
            return $this->processor->processing($block, $framesPerSecond);
        }

        if (null !== $this->nextHandler) {
            return $this->nextHandler->handle($block);
        }

        return null;
    }
}
