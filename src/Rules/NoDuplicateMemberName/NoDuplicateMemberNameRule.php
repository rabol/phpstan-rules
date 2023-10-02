<?php

declare(strict_types=1);

namespace Rabol\PHPStan\Rules\NoDuplicateMemberName;


use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\ShouldNotHappenException;

class NoDuplicateMemberNameRule implements Rule
{
    public function getNodeType(): string
    {
        return Node\Stmt\Class_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (!$node instanceof Node\Stmt\Class_) {
            throw new ShouldNotHappenException();
        }

        $memberNames = [];

        foreach ($node->stmts as $stmt) {
            if ($stmt instanceof Node\Stmt\Property) {
                foreach ($stmt->props as $prop) {
                    $memberNames[$prop->name->toString()] = 'property';
                }
            }

            if ($stmt instanceof Node\Stmt\ClassMethod) {
                $memberNames[$stmt->name->toString()] = 'method';
            }
        }

        $errors = [];
        $countValues = array_count_values($memberNames);

        foreach ($countValues as $name => $count) {
            if ($count > 1) {
                $errors[] = sprintf('Class %s has a %s and method with the name "%s".', $scope->getClassReflection()->getName(), $memberNames[$name], $name);
            }
        }

        return $errors;
    }
}
