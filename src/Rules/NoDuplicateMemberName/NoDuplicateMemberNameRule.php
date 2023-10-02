<?php

declare(strict_types=1);

namespace Rabol\PHPStan\Rules\NoDuplicateMemberName;


use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\ShouldNotHappenException;
use PhpParser\Node\Stmt\Class_;

class NoPropertyAndMethodWithSameNameRule implements Rule
{
    public function getNodeType(): string
    {
        return Class_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $errors = [];

        /** @var Class_ $node */
        $propertyNames = [];
        foreach ($node->stmts as $stmt) {
            if ($stmt instanceof Node\Stmt\Property) {
                foreach ($stmt->props as $prop) {
                    $propertyNames[] = $prop->name->toString();
                }
            }
        }

        foreach ($node->stmts as $stmt) {
            if ($stmt instanceof Node\Stmt\ClassMethod) {
                $methodName = $stmt->name->toString();
                if (in_array($methodName, $propertyNames, true)) {
                    $errors[] = sprintf('Property and method with the name "%s" found in class.', $methodName);
                }
            }
        }

        return $errors;
    }
}
