<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\Factory;

use InvalidArgumentException;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use Mo3golom\WonderStories\Exception\InvalidConfigFileSystemFactoryException;
use Symfony\Component\Yaml\Yaml;
use Valitron\Validator;

class FileSystemFactory implements FileSystemInterface
{
    private array $config;

    public function __construct()
    {
        $this->setConfig(Yaml::parseFile(__DIR__ . '/../../config/Filesystem.yaml'));
    }

    /**
     * @param string $type
     *
     * @return Filesystem
     *
     * @throws InvalidConfigFileSystemFactoryException
     */
    public function adapter(string $type): Filesystem
    {
        switch ($type) {
            case self::LOCAL:
                $this->validateConfig(['required' => ['local.root']]);

                $adapter = new LocalFilesystemAdapter($this->config['local']['root']);

                break;
            default:
                throw new InvalidArgumentException('Неизвестный тип адаптера для FileSystem');
        }

        return new Filesystem($adapter);
    }

    public function setConfig(array $config): FileSystemFactory
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @param array $rules
     *
     * @throws InvalidConfigFileSystemFactoryException
     */
    private function validateConfig(array $rules): void
    {
        $validator = new Validator($this->config);
        $validator->rules($rules);

        if (!$validator->validate()) {
            throw new InvalidConfigFileSystemFactoryException(
                implode(', ', $validator->errors())
            );
        }
    }
}
