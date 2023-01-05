<?php

/**
 * @license MIT
 * @author hazuki3417<hazuki3417@gmail.com>
 * @copyright 2021 hazuki3417 all rights reserved.
 */

namespace Selen\Data;

class Type
{
    public const NAME_ARRAY   = 'array';
    public const NAME_BOOL    = 'bool';
    public const NAME_NUMBER  = 'number';
    public const NAME_DOUBLE  = 'double';
    public const NAME_FLOAT   = 'float';
    public const NAME_INT     = 'int';
    public const NAME_INTEGER = 'integer';
    public const NAME_LONG    = 'long';
    public const NAME_NULL    = 'null';
    public const NAME_NUMERIC = 'numeric';
    public const NAME_SCALAR  = 'scalar';
    public const NAME_STRING  = 'string';

    public static function validate($data, string $typeName): bool
    {
        switch ($typeName) {
            case self::NAME_ARRAY:
                return is_array($data);
            case self::NAME_BOOL:
                return is_bool($data);
            case self::NAME_NUMBER:
            case self::NAME_FLOAT:
            case self::NAME_DOUBLE:
                return is_float($data);
            case self::NAME_INT:
            case self::NAME_INTEGER:
            case self::NAME_LONG:
                return is_int($data);
            case self::NAME_NULL:
                return is_null($data);
            case self::NAME_NUMERIC:
                return is_numeric($data);
            case self::NAME_SCALAR:
                return is_scalar($data);
            case self::NAME_STRING:
                return is_string($data);
            default:
                break;
        }
        return $data instanceof $typeName;
    }
}
