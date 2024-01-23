<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Builder;

use LogicException;
use ReflectionClass;
use Selen\MongoDB\Attribute\SchemaLoader;
use Selen\MongoDB\Attributes\Nest;
use Selen\MongoDB\Builder\Attributes\Build;

class UpdateSchema implements SchemaBuilderInterface
{
    /** @var SchemaLoader */
    private $schemaLoader;

    public function __construct(SchemaLoader $schemaLoader)
    {
        $this->schemaLoader = $schemaLoader;
    }

    /**
     * @param array<mixed,mixed> $input updateする値を渡します
     *
     * @return array<mixed,mixed> updateする値を返します
     */
    public function create(array $input): array
    {
        if ($input === []) {
            $mes = 'Invalid value. An empty array cannot be specified';
            throw new LogicException($mes);
        }

        $schema = [];

        foreach ($input as $key => $inputValue) {
            if (!\array_key_exists($key, $this->schemaLoader->fieldLoaders)) {
                // 入力側のkeyが定義側に存在しないとき
                continue;
            }

            // 入力側のkeyが定義側に存在したとき
            $fieldLoader = $this->schemaLoader->fieldLoaders[$key];

            $attributeNest  = $fieldLoader->attributeNest;
            $attributeBuild = $fieldLoader->fetchAttribute(Build::class);

            $isNestedValueBuild = $attributeNest !== null && $attributeBuild !== null;

            if (!$isNestedValueBuild) {
                // ネストされていない定義のときの処理
                $key          = $fieldLoader->reflectionProperty->getName();
                $value        = $inputValue;
                $schema[$key] = $value;
                continue;
            }

            // ネストされた定義のときの処理

            /** @var Nest */
            $nestInstance = $attributeNest->newInstance();
            $updateSchema = new self(new SchemaLoader(new ReflectionClass($nestInstance->schemaClassName)));

            if ($nestInstance->type === Nest::TYPE_OBJECT) {
                /**
                 * ネストされた値の形式がObject
                 * 上書きする値がリテラル値の場合、定義の形式に合わないため上書き処理をしない。
                 * ネストした定義の値を上書きするには1次元配列で指定する必要がある。
                 */
                $passInput = $inputValue;

                if (!\is_array($passInput)) {
                    continue;
                }

                $key          = $fieldLoader->reflectionProperty->getName();
                $value        = $updateSchema->create($passInput);
                $schema[$key] = $value;
                continue;
            }

            /**
             * ネストされた値の形式がArrayObject
             * 上書きする値がリテラル値の場合、定義の形式に合わないため上書き処理をしない。
             * ネストした定義の値を上書きするには2次元配列で指定する必要がある。
             * （1次はObjectを持つ要素, 2次はObjectのフィールドを持つ要素）
             */
            $inputObjectItems = $inputValue;

            // ObjectItemsを想定した値かどうか確認
            if (!\is_array($inputObjectItems)) {
                // ObjectItemsを想定した値がリテラル値のときは処理しない
                continue;
            }

            $writeObjectItems = [];

            foreach ($inputObjectItems as $index => $inputObjectItem) {
                // ObjectItemを想定した値かどうか確認
                if (!\is_array($inputObjectItem)) {
                    // ObjectItemを想定した値がリテラル値のときは処理しない
                    continue;
                }
                $writeObjectItems[] = $updateSchema->create($inputObjectItem);
            }

            if ($writeObjectItems === []) {
                continue;
            }

            $key          = $fieldLoader->reflectionProperty->getName();
            $value        = $writeObjectItems;
            $schema[$key] = $value;
        }

        return $schema;
    }
}
