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

class UpdateSchema implements SchemaValidatorInterface
{
    /** @var \Selen\Data\ArrayPath */
    public $arrayPath;

    /** @var \Selen\MongoDB\Validator\Model\ValidateResult[] */
    private $validateResults = [];

    /** @var \Selen\MongoDB\Attribute\SchemaLoader */
    private $schemaLoader;

    public function __construct(SchemaLoader $schemaLoader)
    {
        $this->arrayPath    = new ArrayPath();
        $this->schemaLoader = $schemaLoader;
    }

    public function execute(array $input): ValidatorResult
    {
        $this->main($input);
        return new ValidatorResult(...$this->validateResults);
    }

    private function addValidateResults(ValidateResult ...$validateResults)
    {
        $this->validateResults = \array_merge($this->validateResults, $validateResults);
    }

    private function main(array $input)
    {
        $this->arrayPath->down();

        foreach ($input as $key => $value) {
            $keyValue = [$key => $value];

            if (!\array_key_exists($key, $this->schemaLoader->fieldLoaders)) {
                // 入力側のkeyが定義側に存在しないとき
                continue;
            }

            // 入力側のkeyが定義側に存在したとき
            $fieldLoader = $this->schemaLoader->fieldLoaders[$key];

            $attributeValueValidates = $fieldLoader->fetchAttributes(ValueValidateInterface::class);
            $attributeNest           = $fieldLoader->attributeNest;

            $isValueValidateExecute = $attributeValueValidates !== [];
            $isNestValidExecute     = $attributeNest           !== null;

            $key = $fieldLoader->reflectionProperty->getName();
            $this->arrayPath->setCurrentPath($key);

            if ($isValueValidateExecute) {
                // 値のバリデーション処理
                $valueValidator       = new Value($this->arrayPath, $attributeValueValidates);
                $valueValidatorResult = $valueValidator->execute($key, $keyValue);

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
                if (!\is_array($value)) {
                    /**
                     * ここに到達するとき$valueの値は値チェックで許可されたリテラル値
                     * そのためネストした値のバリデーションは実行しないようにする
                     * 例) null | object や null | array object といった属性の指定
                     */
                    $isNestValidExecute = false;
                }
            }

            if ($isNestValidExecute) {
                // ネストした値のバリデーション処理
                /** @var \Selen\MongoDB\Attributes\Nest */
                $nestInstance             = $attributeNest->newInstance();
                $schemaLoader             = new SchemaLoader(new ReflectionClass($nestInstance->schemaClassName));
                $nestValidator            = new self($schemaLoader);
                $nestValidator->arrayPath = $this->arrayPath;

                // ネストした値 = object or array object = inputは1次元または2次元配列を期待
                if (!\is_array($value)) {
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
                    $object = $value;

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
                $objects = $value;

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
