<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB\Validator;

use ReflectionClass;
use Selen\Data\ArrayPath;
use Selen\MongoDB\Attribute\SchemaLoader;
use Selen\MongoDB\Attributes\Nest;
use Selen\MongoDB\Validator\Model\ValidateResult;
use Selen\MongoDB\Validator\Model\ValidatorResult;

class InsertSchema implements SchemaValidatorInterface
{
    /** @var ArrayPath */
    public $arrayPath;

    /** @var Model\ValidateResult[] */
    private $validateResults = [];

    /** @var SchemaLoader */
    private $schemaLoader;

    public function __construct(SchemaLoader $schemaLoader)
    {
        $this->arrayPath    = new ArrayPath();
        $this->schemaLoader = $schemaLoader;
    }

    /**
     * 値の検証を実行します
     *
     * @param array<mixed,mixed> $input 検証する値を渡します
     */
    public function execute(array $input): ValidatorResult
    {
        $this->main($input);
        return new ValidatorResult(...$this->validateResults);
    }

    private function addValidateResults(ValidateResult ...$validateResults): void
    {
        $this->validateResults = \array_merge($this->validateResults, $validateResults);
    }

    /**
     * @param array<mixed,mixed> $input 検証する値を渡します
     */
    private function main(array $input): void
    {
        $this->arrayPath->down();

        /** 検証対象の配列にのみ存在するフィールドを検出する処理 */
        $inputKeys     = array_keys($input);
        $definedKeys   = array_keys($this->schemaLoader->fieldLoaders);
        $undefinedKeys = array_diff($inputKeys, $definedKeys);

        foreach ($undefinedKeys as $undefinedKey) {
            $this->arrayPath->setCurrentPath($undefinedKey);
            $this->validateResults[] = new ValidateResult(
                false,
                ArrayPath::toString($this->arrayPath->getPaths()),
                'Undefined key.'
            );
        }

        foreach ($this->schemaLoader->fieldLoaders as $fieldLoader) {
            $attributeValueValidates = $fieldLoader->fetchAttributes(ValueValidateInterface::class);
            $attributeNest           = $fieldLoader->attributeNest;

            $isValueValidateExecute = $attributeValueValidates !== [];
            $isNestValidExecute     = $attributeNest           !== null;

            $key = $fieldLoader->reflectionProperty->getName();
            $this->arrayPath->setCurrentPath($key);

            $keyValidator       = new Key($this->arrayPath);
            $keyValidatorResult = $keyValidator->execute($key, $input);

            if ($keyValidatorResult->failure()) {
                $this->addValidateResults(...$keyValidatorResult->getValidateResults());
                continue;
            }

            if ($isValueValidateExecute) {
                // 値のバリデーション処理
                $valueValidator       = new Value($this->arrayPath, $attributeValueValidates);
                $valueValidatorResult = $valueValidator->execute($key, $input);

                if ($valueValidatorResult->failure()) {
                    $this->addValidateResults(...$valueValidatorResult->getValidateResults());
                    // 値チェックに違反したら控えている処理は実行しない
                    continue;
                }

                if (!$isNestValidExecute) {
                    // 値チェックが成功 + ネストした値のバリデーションをしない
                    continue;
                }

                // 値チェックが成功 + ネストした値のバリデーションをする
                if (!\is_array($input[$key])) {
                    /**
                     * ここに到達するとき$input[$key]の値は値チェックで許可されたリテラル値
                     * そのためネストした値のバリデーションは実行しないようにする
                     * 例) null | object や null | array object といった属性の指定
                     */
                    $isNestValidExecute = false;
                }
            }

            if ($isNestValidExecute) {
                // ネストした値のバリデーション処理
                /** @var Nest */
                $nestInstance             = $attributeNest->newInstance();
                $schemaLoader             = new SchemaLoader(new ReflectionClass($nestInstance->schemaClassName));
                $nestValidator            = new self($schemaLoader);
                $nestValidator->arrayPath = $this->arrayPath;

                // ネストした値 = object or array object = inputは1次元または2次元配列を期待
                if (!\is_array($input[$key])) {
                    // 値がリテラル型だったとき
                    $format         = 'Invalid value. Expect "%s" schema for array type';
                    $mes            = \sprintf($format, $nestInstance->schemaClassName);
                    $validateResult = new ValidateResult(
                        false,
                        ArrayPath::toString($this->arrayPath->getPaths()),
                        $mes
                    );
                    $this->addValidateResults($validateResult);
                    continue;
                }

                if ($nestInstance->type === Nest::TYPE_OBJECT) {
                    // ネストした値がobject形式
                    $object = $input[$key];

                    if ($object === []) {
                        // 値が空配列だったとき（ネストしたobject形式の配列を期待しているため、keyは必ず存在する）
                        $format         = 'Invalid value. Expect "%s" schema for array type';
                        $mes            = \sprintf($format, $nestInstance->schemaClassName);
                        $validateResult = new ValidateResult(
                            false,
                            ArrayPath::toString($this->arrayPath->getPaths()),
                            $mes
                        );
                        $this->addValidateResults($validateResult);
                        continue;
                    }

                    $nestValidatorResult = $nestValidator->execute($object);

                    if ($nestValidatorResult->failure()) {
                        $this->addValidateResults(...$nestValidatorResult->getValidateResults());
                    }
                    continue;
                }

                // ネストした値がarray object形式
                $objects = $input[$key];

                $nestValidator->arrayPath->down();

                foreach ($objects as $index => $object) {
                    $nestValidator->arrayPath->setCurrentPath('[' . $index . ']');

                    if (!\is_array($object)) {
                        // 値がリテラル型だったとき
                        $format         = 'Invalid value. Expect "%s" schema for array type';
                        $mes            = \sprintf($format, $nestInstance->schemaClassName);
                        $validateResult = new ValidateResult(
                            false,
                            ArrayPath::toString($nestValidator->arrayPath->getPaths()),
                            $mes
                        );
                        $this->addValidateResults($validateResult);
                        continue;
                    }

                    if ($object === []) {
                        // 値が空配列だったとき（ネストしたobject形式の配列を期待しているため、keyは必ず存在する）
                        $format         = 'Invalid value. Expect "%s" schema for array type';
                        $mes            = \sprintf($format, $nestInstance->schemaClassName);
                        $validateResult = new ValidateResult(
                            false,
                            ArrayPath::toString($this->arrayPath->getPaths()),
                            $mes
                        );
                        $this->addValidateResults($validateResult);
                        continue;
                    }

                    $nestValidatorResult = $nestValidator->execute($object);

                    if ($nestValidatorResult->failure()) {
                        $this->addValidateResults(...$nestValidatorResult->getValidateResults());
                    }
                }
                $nestValidator->arrayPath->up();
                continue;
            }
        }
        $this->arrayPath->up();
    }
}
