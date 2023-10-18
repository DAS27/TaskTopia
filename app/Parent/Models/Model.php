<?php

declare(strict_types=1);

namespace App\Parent\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @return Factory<Model>|null
     */
    protected static function newFactory()
    {
        $separator = '\\';
        $containersFactoriesPath = $separator . 'Factories' . $separator;
        $fullPathSections = explode($separator, static::class);
        $containerName = $fullPathSections[2];
        $nameSpace = $separator . 'App' . $separator . 'Domain' . $separator . $containerName . $containersFactoriesPath;

        Factory::useNamespace($nameSpace);
        /** @var class-string<\Illuminate\Database\Eloquent\Model> $className */
        $className = class_basename(static::class);

        if (! class_exists($nameSpace . $className . 'Factory')) {
            return null;
        }

        return Factory::factoryForModel($className);
    }
}
