<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2024 hazuki3417 all rights reserved.
 */

 namespace Selen\Array;

use ArrayIterator;

/**
 * 配列の操作を提供するクラスです。
 */
class ArrayOperation
{
    public const SEARCH_CONDITION_KEY     = 'key';
    public const SEARCH_CONDITION_VALUE   = 'value';
    public const SEARCH_CONDITION_ELEMENT = 'element';
    public const RETURN_CONDITION_KEY     = 'key';
    public const RETURN_CONDITION_VALUE   = 'value';
    public const RETURN_CONDITION_ELEMENT = 'element';

    /** @var ArrayIterator<int|string,mixed> イテレータクラスのインスタンス  */
    private ArrayIterator $arrayIterator;

    /**
     * 新しいArrayOperationインスタンスを生成します。
     *
     * @param ArrayIterator<int|string,mixed> $arrayIterator イテレータクラスのインスタンスを渡します
     */
    public function __construct(ArrayIterator $arrayIterator)
    {
        $this->arrayIterator = $arrayIterator;
    }

    /**
     * 新しいArrayOperationインスタンスを生成します。
     *
     * @param array<mixed,mixed> $value 配列を渡します
     */
    public static function set(array $value): ArrayOperation
    {
        return new self(new ArrayIterator($value));
    }

    /**
     * 配列のキーを取得します
     *
     * @return array<int,mixed> 配列のキーを返します
     */
    public function getKeys(): array
    {
        return array_keys($this->arrayIterator->getArrayCopy());
    }

    /**
     * 配列の値を取得します
     *
     * @return array<int,mixed> 配列の値を返します
     */
    public function getValues(): array
    {
        return array_values($this->arrayIterator->getArrayCopy());
    }

    /**
     * 配列の要素を取得します
     *
     * @return array<mixed,mixed> 配列の要素を返します
     */
    public function getElements(): array
    {
        return $this->arrayIterator->getArrayCopy();
    }

    /**
     * 指定した条件に一致する要素を取得します
     *
     * @param string $returnCondition 取得条件を指定します
     *
     * @return array<mixed,mixed> 配列を返します
     */
    public function get(string $returnCondition = self::RETURN_CONDITION_ELEMENT): array
    {
        switch ($returnCondition) {
            case self::RETURN_CONDITION_KEY:
                return $this->getKeys();
            case self::RETURN_CONDITION_VALUE:
                return $this->getValues();
            case self::RETURN_CONDITION_ELEMENT:
                return $this->getElements();
            default:
                break;
        }
        throw new \InvalidArgumentException('invalid return condition.');
    }

    /**
     * 配列の先頭要素を取得します
     *
     * @param string $searchCondition 検索条件を指定します
     *
     * @return array<mixed,mixed> 配列を返します
     */
    public function getFirst(string $searchCondition = self::SEARCH_CONDITION_ELEMENT): array
    {
        $isEmpty = $this->arrayIterator->count() === 0;

        if (!$isEmpty) {
            $this->arrayIterator->rewind();
        }

        switch ($searchCondition) {
            case self::SEARCH_CONDITION_KEY:
                return $isEmpty ? [] : [$this->arrayIterator->key()];
            case self::SEARCH_CONDITION_VALUE:
                return $isEmpty ? [] : [$this->arrayIterator->current()];
            case self::SEARCH_CONDITION_ELEMENT:
                return $isEmpty ? [] : [$this->arrayIterator->key() => $this->arrayIterator->current()];
            default:
                break;
        }
        throw new \InvalidArgumentException('invalid search condition.');
    }

    /**
     * 配列の末尾要素を取得します
     *
     * @param string $searchCondition 検索条件を指定します
     *
     * @return array<mixed,mixed> 配列を返します
     */
    public function getLast(string $searchCondition = self::SEARCH_CONDITION_ELEMENT): array
    {
        $isEmpty = $this->arrayIterator->count() === 0;

        if (!$isEmpty) {
            $lastIndex = $this->arrayIterator->count() - 1;
            $this->arrayIterator->seek($lastIndex);
        }

        switch ($searchCondition) {
            case self::SEARCH_CONDITION_KEY:
                return $isEmpty ? [] : [$this->arrayIterator->key()];
            case self::SEARCH_CONDITION_VALUE:
                return $isEmpty ? [] : [$this->arrayIterator->current()];
            case self::SEARCH_CONDITION_ELEMENT:
                return $isEmpty ? [] : [$this->arrayIterator->key() => $this->arrayIterator->current()];
            default:
                break;
        }
        throw new \InvalidArgumentException('invalid search condition.');
    }

    /**
     * 指定した要素に一致する要素を抽出します
     *
     * @param array<int,array<string|int,mixed>> $elements 検索対象の要素を指定します
     */
    public function filterByElement(array $elements): ArrayOperation
    {
        for ($this->arrayIterator->rewind(); $this->arrayIterator->valid();) {
            $isElementMatch = false;

            foreach ($elements as $elementKey => $elementValue) {
                $isKeyMatch   = $elementKey   === $this->arrayIterator->key();
                $isValueMatch = $elementValue === $this->arrayIterator->current();

                if ($isKeyMatch && $isValueMatch) {
                    $isElementMatch = true;
                    break;
                }
            }

            $isElementMatch ?
                $this->arrayIterator->next() :
                $this->arrayIterator->offsetUnset($this->arrayIterator->key());
        }
        return $this;
    }

    /**
     * 指定したkeyに一致する要素を抽出します
     *
     * @param string|int $key 検索対象のkeyを指定します
     */
    public function filterByKey(string|int ...$key): ArrayOperation
    {
        for ($this->arrayIterator->rewind(); $this->arrayIterator->valid();) {
            in_array($this->arrayIterator->key(), $key, true) ?
                $this->arrayIterator->next() :
                $this->arrayIterator->offsetUnset($this->arrayIterator->key());
        }
        return $this;
    }

    /**
     * 指定したvalueに一致する要素を抽出します
     *
     * @param mixed $value 検索対象のvalueを指定します
     */
    public function filterByValue(mixed ...$value): ArrayOperation
    {
        for ($this->arrayIterator->rewind(); $this->arrayIterator->valid();) {
            in_array($this->arrayIterator->current(), $value, true) ?
                $this->arrayIterator->next() :
                $this->arrayIterator->offsetUnset($this->arrayIterator->key());
        }
        return $this;
    }

    /**
     * 指定した条件に一致する要素を抽出します
     *
     * @param array<mixed,mixed> $needle          検索対象の要素を指定します
     * @param string             $searchCondition 検索条件を指定します
     */
    public function filter(array $needle, string $searchCondition = self::SEARCH_CONDITION_ELEMENT): ArrayOperation
    {
        switch ($searchCondition) {
            case self::SEARCH_CONDITION_KEY:
                return $this->filterByKey(...$needle);
            case self::SEARCH_CONDITION_VALUE:
                return $this->filterByValue(...$needle);
            case self::SEARCH_CONDITION_ELEMENT:
                return $this->filterByElement($needle);
            default:
                break;
        }
        throw new \InvalidArgumentException('invalid search condition.');
    }
}
