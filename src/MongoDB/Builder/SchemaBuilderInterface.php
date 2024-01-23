<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Builder;

interface SchemaBuilderInterface
{
    /**
     * @param array<mixed,mixed> $input 入力値を渡します
     *
     * @return array<mixed,mixed> コレクション投入する値を返します
     */
    public function create(array $input): array;
}
