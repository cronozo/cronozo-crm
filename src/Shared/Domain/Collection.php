<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Webmozart\Assert\Assert;

/**
 * @template TKey as int|string
 * @template TValue
 *
 * @implements IteratorAggregate<TKey, TValue>
 */
abstract class Collection implements Countable, IteratorAggregate
{
    /**
     * @param array<TKey, TValue> $items
     */
    public function __construct(private array $items)
    {
        Assert::allIsInstanceOf($items, $this->type());
    }

    /**
     * @return class-string<object>
     */
    abstract protected function type(): string;

    /**
     * @return ArrayIterator<TKey, TValue>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items());
    }

    public function count(): int
    {
        return \count($this->items());
    }

    /**
     * @return array<TKey, TValue>
     */
    protected function items(): array
    {
        return $this->items;
    }
}
