<?php

declare(strict_types=1);

namespace App\Parent\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

abstract class Repository extends BaseRepository
{
    /**
     * This function relies on strict conventions:
     *    - Repository name should be same as it's model name (model: Foo -> repository: FooRepository).
     *    - If the container contains Models with names different from the container name, the repository class must
     *      implement model() method and return the FQCN e.g. Role::class
     */
    public function model(): string
    {
        $className = $this->getClassName(); // e.g. UserRepository
        $modelName = $this->getModelName($className); // e.g. User
        /** @var string $modelName */
        $modelName = preg_replace('/Cache$/', '', $modelName);

        return $this->getModelNamespace($modelName);
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot(): void
    {
    }

    private function getClassName(): string
    {
        $fullName = static::class;

        return substr($fullName, strrpos($fullName, '\\') + 1);
    }

    private function getModelName(string $className): string
    {
        return str_replace(['Repository', 'EntityManager'], '', $className);
    }

    private function getModelNamespace(string $modelName): string
    {
        return 'App\\Domain\\' . $this->getCurrentContainer() . '\\Models\\' . $modelName;
    }

    private function getCurrentContainer(): string
    {
        return explode('\\', static::class)[2];
    }
}
