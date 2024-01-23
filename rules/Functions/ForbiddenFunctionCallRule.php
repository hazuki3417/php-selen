<?php

namespace Rules\Selen\Functions;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * PHPStanのカスタムルール
 * forbiddenFunctionsに指定した関数名が使用されていたらエラーにするルール
 */
class ForbiddenFunctionCallRule implements Rule
{
    private $forbiddenFunctions = [
        // php standard functions
        'exit',
        'exec',
        'shell_exec',
        'system',
        'var_dump',
        'var_export',
        'eval',
        'phpinfo',
    ];

    public function getNodeType(): string
    {
        return Node\Expr\FuncCall::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if ($node instanceof Node\Expr\FuncCall && $node->name instanceof Node\Name) {
            $functionName = $node->name->toString();

            if (in_array($functionName, $this->forbiddenFunctions, true)) {
                return [
                    RuleErrorBuilder::message("Call to forbidden function '{$functionName}'.")->build(),
                ];
            }
        }

        return [];
    }
}
