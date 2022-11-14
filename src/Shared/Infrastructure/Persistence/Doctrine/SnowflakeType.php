<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine;

use App\Shared\Domain\Utils;
use App\Shared\Domain\ValueObject\IntValueObject;
use App\Shared\Infrastructure\Doctrine\Dbal\DoctrineCustomType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;
use function Lambdish\Phunctional\last;

abstract class SnowflakeType extends IntegerType implements DoctrineCustomType
{
    abstract protected function typeClassName(): string;

    public static function customTypeName(): string
    {
        return Utils::toSnakeCase(str_replace('Type', '', last(explode('\\', static::class))));
    }

    public function getName(): string
    {
        return self::customTypeName();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $className = $this->typeClassName();

        return new $className($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /* @var IntValueObject $value */
        return $value->value();
    }
}
