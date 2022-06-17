<?php

namespace App\PHPStan;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

class ExamplePHPStanRule implements Rule
{
    public function getNodeType(): string
    {
        return Node\Expr\FuncCall::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        /** @var $node Node\Expr\FuncCall */

        if (!$scope->isInClass()) {
            return [];
        }

        $classReflection = $scope->getClassReflection();

        if (null === $classReflection || !str_starts_with($classReflection->getName(), 'App\Test\\')) {
            return [];
        }

        if ('file_get_contents' !== $node->name->toString()) {
            return [];
        }

        $filePath = $node->args[0]->value;

        if (!$filePath instanceof Node\Expr\BinaryOp\Concat) {
            return [];
        }


        if (!$filePath->left instanceof Node\Scalar\MagicConst\Dir || !$filePath->right instanceof Node\Scalar\String_) {
            return [];
        }

        $value = $filePath->right->value;

        if (0 === preg_match('#^[a-z_\d./]+$#', $value)) {
            return [
                RuleErrorBuilder::message(sprintf(
                    'The path to resource file ("%s") should be snake_case',
                  $value
              ))->build(),
            ];
        }

        return [];
    }
}
