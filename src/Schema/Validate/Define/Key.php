<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Schema\Validate\Define;

use InvalidArgumentException;
use Selen\Data\Types;

class Key
{
    /** @var string|int|null key名 */
    private $name;

    /** @var string[] */
    private $nameAllowType = ['string', 'integer', 'null'];

    /** @var bool */
    private $require;

    /**
     * インスタンスを生成します
     *
     * @param string|int|null $name key名を指定します。index arrayの場合はnullを渡します。
     *
     * @return \Selen\Schema\Validate\Define\Key
     *
     * @throws \InvalidArgumentException 引数の型が不正なときに発生します
     */
    public function __construct($name, bool $require)
    {
        if (!$this->verifyNameType($name)) {
            $format = 'Invalid $name type. expected type %s.';
            $mes    = \sprintf($format, \implode(', ', $this->nameAllowType));
            throw new InvalidArgumentException($mes);
        }
        $this->name    = $name;
        $this->require = $require;
    }

    /**
     * key名を取得します
     *
     * @return string|int|null key名を返します
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * keyの必須有無を取得します
     *
     * @return bool 必須の場合はtrueを、それ以外の場合はfalseを返します
     */
    public function getRequire()
    {
        return $this->require;
    }

    /**
     * key名の型を検証します
     *
     * @param string|int|null $value
     *
     * @return bool 合格した場合はtrueを、それ以外の場合はfalseを返します
     */
    private function verifyNameType($value)
    {
        return Types::validate($value, ...$this->nameAllowType);
    }
}
