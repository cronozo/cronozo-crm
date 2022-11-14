<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use function Lambdish\Phunctional\filter;
use function Symfony\Component\String\u;

final class Utils
{
    public static function dateToString(\DateTimeInterface $date): string
    {
        return $date->format(\DateTimeInterface::ATOM);
    }

    public static function stringToDate(string $date): \DateTimeImmutable
    {
        return new \DateTimeImmutable($date);
    }

    /**
     * @param array<int|string, mixed> $values
     *
     * @throws \JsonException
     */
    public static function jsonEncode(array $values): string
    {
        return json_encode($values, \JSON_THROW_ON_ERROR);
    }

    /**
     * @throws \JsonException
     *
     * @return array<int|string, mixed>
     */
    public static function jsonDecode(string $json): array
    {
        $data = json_decode($json, true, 512, \JSON_THROW_ON_ERROR);

        if (\JSON_ERROR_NONE !== json_last_error()) {
            throw new \RuntimeException('Unable to parse response body into JSON: ' . json_last_error());
        }

        return $data;
    }

    public static function toSnakeCase(string $text): string
    {
        return u($text)->snake()->toString();
    }

    public static function toCamelCase(string $text): string
    {
        return u($text)->camel()->toString();
    }

    /**
     * @param array<int|string, mixed> $array
     *
     * @return array<int|string, mixed>
     */
    public static function dot(array $array, string $prepend = ''): array
    {
        $results = [];
        foreach ($array as $key => $value) {
            if (\is_array($value) && !empty($value)) {
                $results = array_merge($results, static::dot($value, $prepend . $key . '.'));
            } else {
                $results[$prepend . $key] = $value;
            }
        }

        return $results;
    }

    /**
     * @return array<string, string>
     */
    public static function filesIn(string $path, string $fileType): array
    {
        return filter(
            static fn (string $possibleModule) => mb_strstr($possibleModule, $fileType),
            (array) scandir($path)
        );
    }

    public static function extractClassName(object $object): string
    {
        return (new \ReflectionClass($object))->getShortName();
    }
}
