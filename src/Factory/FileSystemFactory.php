<?php

declare(strict_types=1);

namespace Mo3golom\WonderStories\Factory;

use InvalidArgumentException;
use League\Flysystem\Adapter\Local;
use Mo3golom\WonderStories\Exception\InvalidConfigFileSystemFactoryException;
use Mo3golom\WonderStories\Filesystem\Filesystem;
use Mo3golom\WonderStories\Helper\KernelHelper;
use Valitron\Validator;

/**
 * Class FileSystemFactory
 */
class FileSystemFactory implements FileSystemInterface
{
    private array $config;

    /**
     * FileSystemFactory constructor.
     *
     * @param array|null $config
     *
     * @psalm-suppress UnresolvableInclude
     */
    public function __construct(?array $config = null)
    {
        $this->config = $config ?? require(KernelHelper::getProjectDir() . '/config/filesystem.php');
    }

    /**
     * @param string $type
     *
     * @return \Mo3golom\WonderStories\Filesystem\Filesystem
     *
     * @throws InvalidConfigFileSystemFactoryException
     */
    public function adapter(string $type): Filesystem
    {
        switch ($type) {
            case self::LOCAL:
                $this->validateConfig(['required' => ['local.root']]);

                $adapter = new Local(
                    sprintf(
                        '%s/%s',
                        KernelHelper::getProjectDir(),
                        ltrim($this->config[self::LOCAL]['root'], '/\\')
                    )
                );

                break;
            default:
                throw new InvalidArgumentException('Неизвестный тип адаптера для FileSystem');
        }

        return new Filesystem($adapter);
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
