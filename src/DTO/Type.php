<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\DTO;

class Type
{
    private string $id;

    private array $settings;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): Type
    {
        $this->id = $id;

        return $this;
    }

    public function getSettings(): array
    {
        return $this->settings;
    }

    public function setSettings(array $settings): Type
    {
        $this->settings = $settings;

        return $this;
    }
}
