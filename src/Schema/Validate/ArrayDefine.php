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
    /** @var Define[] key定義 */
    public $defines;

    /** @var array<int,int|string> key名一覧 */
    public $keys = [];

    /** @var bool Index配列定義の存在有無 */
    public bool $indexArrayDefineExists = false;

    /** @var bool Assoc配列定義の存在有無 */
    public bool $assocArrayDefineExists = false;

    /**
     * ArrayDefineインスタンスを生成します
     *
     * @param Define $defines 定義を渡します
     *
     * @return ArrayDefine
     *
     * @throws LogicException Defineクラスの定義が不正なときに発生します
     */
    public function __construct(Define ...$defines)
    {
        foreach ($defines as $define) {
            /** @var bool $isIndexDefineDuplicate index配列の定義が複数存在するか */
            $isIndexDefineDuplicate = $this->indexArrayDefineExists && $define->isIndexArrayDefine();

            $errMes = 'Illegal combination of Define classes.';

            if ($isIndexDefineDuplicate) {
                $reasonMes = 'Multiple definitions without key cannot be specified.';
                $mes       = \sprintf('%s %s', $errMes, $reasonMes);
                throw new LogicException($mes);
            }

            if ($define->isIndexArrayDefine()) {
                $this->indexArrayDefineExists = true;
                // NOTE: Index配列の場合はkey名の一覧を作らない
            }

            if ($define->isAssocArrayDefine()) {
                $this->assocArrayDefineExists = true;
                $this->keys[]                 = $define->key->getName();
            }

            $isDefineConflict = $this->indexArrayDefineExists && $this->assocArrayDefineExists;

            if ($isDefineConflict) {
                $reasonMes = 'Definitions with and without key are mixed.';
                $mes       = \sprintf('%s %s', $errMes, $reasonMes);
                throw new LogicException($mes);
            }
        }

        $this->defines = $defines;
    }
}
