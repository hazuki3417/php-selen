<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Data\Structure;

use Selen\Data\Type;

final class Collection extends AbstractCollection
{
    /** @var string 型名またはクラス名 */
    private string $typeName;

    public function __construct(string $typeName)
    {
        $this->typeName = $typeName;
    }

    /**
     * オブジェクトを追加します
     *
     * @param mixed $object 追加するオブジェクトを渡します
     *
     * @return bool 成功した場合はtrueを返します
     *
     * @throws \InvalidArgumentException 型が一致しない場合にスローします
     */
    public function add($object): bool
    {
        $isExpectedType = Type::validate($object, $this->typeName);

        if (!$isExpectedType) {
            throw new \InvalidArgumentException('Invalid argument type.');
        }
        $this->objects[] = $object;

        return true;
    }

    /**
     * オブジェクトを削除します
     *
     * @param mixed $object 削除するオブジェクトを渡します
     *
     * @return bool オブジェクトを削除できた場合はtrueを返します
     *
     * @throws \InvalidArgumentException 型が一致しない場合にスローします
     */
    public function remove($object): bool
    {
        $isExpectedType = Type::validate($object, $this->typeName);

        if (!$isExpectedType) {
            throw new \InvalidArgumentException('Invalid argument type.');
        }

        $index = \array_search($object, $this->objects, true);

        if ($index !== false) {
            unset($this->objects[$index]);
        }

        return true;
    }
}
