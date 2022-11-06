<?php

namespace App\PHPStan;

use App\App\AdapterInterface;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Node\InClassNode;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

class AdapterNameRule implements Rule
{
    /**
     * @var string
     */
    public const ERROR_MESSAGE = 'Class should have suffix "%s" when implement "%s" interface';

    private string $interfaceName;

    /**
     * @param array<class-string> $interfaceName
     */
    public function __construct(string $interfaceName)
    {
        $this->interfaceName = $interfaceName;
    }

    public function getNodeType(): string
    {
        return InClassNode::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $classLike = $node->getOriginalNode();
        if (! $classLike instanceof Class_) {
            return [];
        }

        $classReflection = $node->getClassReflection();
        if ($classReflection->isAbstract()) {
            return [];
        }

        if ($classReflection->isAnonymous()) {
            return [];
        }

        return $this->processClassNameAndShort($classReflection);
    }

    /**
     * @return array<int, string>
     */
    private function processClassNameAndShort(ClassReflection $classReflection): array
    {
        if (! $classReflection->isSubclassOf($this->interfaceName)) {
            return [];
        }

        $expectedSuffix = 'Adapter';
        if (substr_compare($classReflection->getName(), $expectedSuffix, -strlen($expectedSuffix)) === 0) {
            return [];
        }

        return [
            RuleErrorBuilder::message(sprintf(
                self::ERROR_MESSAGE,
                $expectedSuffix,
                AdapterInterface::class
            ))->build(),
        ];
    }
}
