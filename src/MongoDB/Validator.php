<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\MongoDB;

use ReflectionAttribute;
use ReflectionClass;
use Selen\Data\ArrayPath;
use Selen\MongoDB\Attributes\Schema\RootObject;
use Selen\MongoDB\Validate\FieldAttribute;
use Selen\MongoDB\Validate\Model\ValidateResult;
use Selen\MongoDB\Validate\Model\ValidatorResult;

class Validator
{
    /** @var \Selen\Data\ArrayPath */
    private $arrayPath;

    /** @var \Selen\MongoDB\Validate\FieldAttribute[] */
    private $fieldAttributes = [];

    /** @var \Selen\MongoDB\Validate\Model\ValidateResult[] */
    private $validateResults = [];

    /**
     * インスタンスを生成します
     *
     * @return \Selen\MongoDB\Validator
     */
    private function __construct()
    {
        $this->arrayPath = new ArrayPath();
    }

    /**
     * インスタンスを生成します
     *
     * @return \Selen\MongoDB\Validator
     */
    public static function new(): Validator
    {
        return new self();
    }

    public function schema(string $name): Validator
    {
        $reflectionClass = new ReflectionClass($name);

        $attributes = $reflectionClass->getAttributes(RootObject::class);

        $expectedAttributeCount = 1;

        if ($expectedAttributeCount !== count($attributes)) {
            $format = 'Invalid attribute specification. Only one "%s" can be specified.';
            $mes    = \sprintf($format, RootObject::class);
            throw new \LogicException($mes);
        }

        foreach ($reflectionClass->getProperties() as $reflectionProperty) {
            $fieldAttribute = new FieldAttribute($reflectionProperty);

            if (!$fieldAttribute->isSchemaAttributeExists()) {
                // schemaのattributeがない場合は処理対象外とする
                continue;
            }
            // schemaのattributeがある場合は処理対象とする
            $this->fieldAttributes[] = $fieldAttribute;
        }

        return $this;
    }

    /**
     * Schema/Validation/ArrayDefineクラスを利用したバリデーション（予定）
     * こっちを利用した場合は、attributeを利用したバリデーション定義は無視される想定
     */
    public function schemaDefine(): Validator
    {
        // バリデーションの定義を上書きするi/fを追加するか検討する
        return $this;
    }

    public function execute(array $input): ValidatorResult
    {
        $this->defineRoutine($input, $this->fieldAttributes);
        return new ValidatorResult(...$this->validateResults);
    }

    /**
     * メイン処理
     *
     * @param \Selen\MongoDB\Validate\FieldAttribute[]
     */
    private function defineRoutine(array $input, array $fieldAttributes)
    {
        // TODO: プロパティにmongodbのattributeがないときの挙動を考える
        $this->arrayPath->down();
        /** @var \Selen\MongoDB\Validate\FieldAttribute[] $fieldAttributes */
        foreach ($fieldAttributes as $fieldAttribute) {
            $fieldName = $fieldAttribute->reflectionProperty->getName();
            $this->arrayPath->setCurrentPath($fieldName);

            $validateResult          = $this->keyValidate($fieldAttribute, $input);
            $this->validateResults[] = $validateResult;

            if (!$validateResult->getResult()) {
                // filedの検証結果が不合格なら値の検証は行わない
                continue;
            }

            if (!$fieldAttribute->isValidateAttributeExists()) {
                // 値を検証するattributeがない場合は値の検証を行わない
                continue;
            }

            $fieldValue = $input[$fieldName];

            foreach ($fieldAttribute->validateAttributes as $validateAttribute) {
                $validateResult          = $this->valueValidate($validateAttribute, $fieldValue);
                $this->validateResults[] = $validateResult;

                if (!$validateResult->getResult()) {
                    // 検証結果が不合格の場合は控えている検証処理は実行しない
                    break;
                }
                // 検証結果が合格の場合は控えている検証処理を実行する
            }
        }
        $this->arrayPath->up();
    }

    /**
     * 配列の階層パス文字列を取得します
     *
     * @return string 配列の階層パス文字列を返します
     */
    private function getArrayPathStr(): string
    {
        return ArrayPath::toString($this->arrayPath->getPaths());
    }

    private function keyValidate(FieldAttribute $fieldAttribute, $value): ValidateResult
    {
        $validateResult = new ValidateResult(true, $this->getArrayPathStr());
        $fieldName      = $fieldAttribute->reflectionProperty->getName();
        return \array_key_exists($fieldName, $value) ?
            $validateResult :
            $validateResult->setResult(false)->setMessage('field is required.');
    }

    private function valueValidate(ReflectionAttribute $validateAttribute, $value): ValidateResult
    {
        $validateResult = new ValidateResult(true, $this->getArrayPathStr());
        /** @var \Selen\MongoDB\Attributes\Validate\ValueValidateInterface $validateInstance */
        $validateInstance = $validateAttribute->newInstance();
        return $validateInstance->execute($value, $validateResult);
    }
}
