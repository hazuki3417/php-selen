<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Builder;

use ReflectionClass;
use Selen\MongoDB\Attribute\SchemaLoader;
use Selen\MongoDB\Attributes\Nest;
use Selen\MongoDB\Builder\Attributes\Build;

class InsertSchema implements SchemaBuilderInterface
{
    /** @var SchemaLoader */
    private $schemaLoader;

    public function __construct(SchemaLoader $schemaLoader)
    {
        $this->schemaLoader = $schemaLoader;
    }

    public function create(array $input): array
    {
        $schema = [];

        foreach ($this->schemaLoader->fieldLoaders as $fieldLoader) {
            $attributeNest  = $fieldLoader->attributeNest;
            $attributeBuild = $fieldLoader->fetchAttribute(Build::class);

            $isNestedValueBuild = $attributeNest !== null && $attributeBuild !== null;

            if (!$isNestedValueBuild) {
                // ネストされていない定義のときの処理
                $key          = $fieldLoader->reflectionProperty->getName();
                $value        = $fieldLoader->reflectionProperty->getDefaultValue();
                $schema[$key] = $value;

                if (!\array_key_exists($key, $input)) {
                    // input側に上書きする値がないときの処理
                    continue;
                }

                // input側の値で上書きする値があるときの処理
                $schema[$key] = $input[$key];
                continue;
            }

            // ネストされた定義のときの処理

            /** @var Nest */
            $nestInstance = $attributeNest->newInstance();
            $insertSchema = new self(new SchemaLoader(new ReflectionClass($nestInstance->schemaClassName)));

            if ($nestInstance->type === Nest::TYPE_OBJECT) {
                /**
                 * ネストされた値の形式がObject
                 * 上書きする値がリテラル値の場合、定義の形式に合わないため上書き処理をしない。
                 * ネストした定義の値を上書きするには1次元配列で指定する必要がある。
                 */
                $passInput = [];

                if (\array_key_exists($fieldLoader->reflectionProperty->getName(), $input)) {
                    $passInput = $input[$fieldLoader->reflectionProperty->getName()];
                }

                if (!\is_array($passInput)) {
                    $passInput = [];
                }

                $key          = $fieldLoader->reflectionProperty->getName();
                $value        = $insertSchema->create($passInput);
                $schema[$key] = $value;
                continue;
            }

            /**
             * ネストされた値の形式がArrayObject
             * 上書きする値がリテラル値の場合、定義の形式に合わないため上書き処理をしない。
             * ネストした定義の値を上書きするには2次元配列で指定する必要がある。
             * （1次はObjectを持つ要素, 2次はObjectのフィールドを持つ要素）
             */
            $key          = $fieldLoader->reflectionProperty->getName();
            $value        = [];
            $schema[$key] = $value;

            if (!\array_key_exists($key, $input)) {
                // input側に上書きする値がないときの処理
                continue;
            }

            // input側に上書きする値があるときの処理

            $inputObjectItems = $input[$key];

            // ObjectItemsを想定した値かどうか確認
            if (!\is_array($inputObjectItems)) {
                // ObjectItemsを想定した値がリテラル値のときは処理しない
                continue;
            }

            $writeObjectItems = [];

            foreach ($inputObjectItems as $inputObjectItem) {
                // ObjectItemを想定した値かどうか確認
                if (!\is_array($inputObjectItem)) {
                    // ObjectItemを想定した値がリテラル値のときは処理しない
                    continue;
                }
                $writeObjectItems[] = $insertSchema->create($inputObjectItem);
            }
            $schema[$key] = $writeObjectItems;
        }
        return $schema;
    }
}
