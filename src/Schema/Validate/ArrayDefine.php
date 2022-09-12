<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2022 hazuki3417 all rights reserved.
 */

namespace Selen\Schema\Validate;

use LogicException;

class ArrayDefine
{
    /** @var \Selen\Schema\Validate\Define[] key定義 */
    public $defines;

    /**
     * ArrayDefineインスタンスを生成します
     *
     * @param Define ...$defines 定義を渡します
     *
     * @return \Selen\Schema\Validate\ArrayDefine
     *
     * @throws \LogicException Defineクラスの定義が不正なときに発生します
     */
    public function __construct(Define ...$defines)
    {
        $indexArrayDefineExists = false;
        $assocArrayDefineExists = false;

        foreach ($defines as $define) {
            /** @var bool $isIndexDefineDuplicate index配列の定義が複数存在するか */
            $isIndexDefineDuplicate = $indexArrayDefineExists && $define->isIndexArrayDefine();

            $errMes = 'Illegal combination of Define classes.';

            if ($isIndexDefineDuplicate) {
                $reasonMes = 'Multiple definitions without key cannot be specified.';
                $mes       = \sprintf('%s %s', $errMes, $reasonMes);
                throw new LogicException($mes);
            }

            if ($define->isIndexArrayDefine()) {
                $indexArrayDefineExists = true;
            }

            if ($define->isAssocArrayDefine()) {
                $assocArrayDefineExists = true;
            }

            $isDefineConflict = $indexArrayDefineExists && $assocArrayDefineExists;

            if ($isDefineConflict) {
                $reasonMes = 'Definitions with and without key are mixed.';
                $mes       = \sprintf('%s %s', $errMes, $reasonMes);
                throw new LogicException($mes);
            }
        }

        $this->defines = $defines;
    }
}
