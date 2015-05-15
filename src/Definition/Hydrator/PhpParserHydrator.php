<?php

namespace Yelirekim\Introspective\Definition\Hydrator;

use PhpParser\Node;
use Yelirekim\Introspective\Definition;

class PhpParserHydrator
{
    public function class_(Node\Stmt\Class_ $node)
    {
        $class = new Definition\Class_;
        $class->name = $node->name;
        $namespaceParts = $node->namespacedName->parts;
        array_pop($namespaceParts);
        $class->namespace = implode('\\', $namespaceParts);
        foreach ($node->getMethods() as $methodNode) {
            $class->methods[] = $this->method($methodNode);
        }
        foreach ($node->stmts as $statementNode) {
            if($statementNode instanceof Node\Stmt\Property) {
                $class->properties[] = $this->property($statementNode);
            }
        }
        if($node->extends) {
            $class->extends = $node->extends->__toString();
        }
        return $class;
    }

    public function method(Node\Stmt\ClassMethod $node)
    {
        $method = new Definition\Method;
        $method->name = $node->name;
        if($node->isProtected()) {
            $method->visibility = 'protected';
        } elseif($node->isPrivate()) {
            $method->visibility = 'private';
        }
        $method->static = $node->isStatic();
        foreach ($node->params as $parameterNode) {
            $method->parameters[] = $this->parameter($parameterNode);
        }
        return $method;
    }

    public function parameter(Node\Param $node)
    {
        $parameter = new Definition\Parameter;
        $parameter->name = $node->name;
        return $parameter;
    }

    public function property(Node\Stmt\Property $node)
    {
        $property = new Definition\Property;
        $property->name = $node->props[0]->name;
        if($node->isProtected()) {
            $property->visibility = 'protected';
        } elseif($node->isPrivate()) {
            $property->visibility = 'private';
        }
        $property->static = $node->isStatic();
        return $property;
    }
}
