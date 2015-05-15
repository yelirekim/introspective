<?php

namespace Yelirekim\Introspective\Definition\Hydrator;

use Yelirekim\Introspective\Definition;

class ReflectionHydrator
{
    public function class_(\ReflectionClass $class)
    {
        $definition = new Definition\Class_;
        $definition->name = $class->getShortName();
        $definition->namespace = $class->getNamespaceName();
        if($parent = $class->getParentClass()) {
            $definition->extends = $parent->getName();
        }
        foreach($class->getProperties() as $property) {
            if($property->getDeclaringClass() == $class) {
                $definition->properties[] = $this->property($property);
            }
        }
        foreach($class->getMethods() as $method) {
            if($method->getDeclaringClass() == $class) {
                $definition->methods[] = $this->method($method);
            }
        }

        return $definition;
    }

    public function method(\ReflectionMethod $method)
    {
        $definition = new Definition\Method;
        $definition->name = $method->getName();
        if($method->isProtected()) {
            $definition->visibility = 'protected';
        } elseif($method->isPrivate()) {
            $definition->visibility = 'private';
        }
        foreach ($method->getParameters() as $parameter) {
            $definition->parameters[] = $this->parameter($parameter);
        }
        $definition->static = $method->isStatic();
        return $definition;
    }

    public function parameter(\ReflectionParameter $parameter)
    {
        $definition = new Definition\Parameter;
        $definition->name = $parameter->getName();
        return $definition;
    }

    public function property(\ReflectionProperty $property)
    {
        $definition = new Definition\Property;
        $definition->name = $property->getName();
        if($property->isProtected()) {
            $definition->visibility = 'protected';
        } elseif($property->isPrivate()) {
            $definition->visibility = 'private';
        }
        $definition->static = $property->isStatic();
        return $definition;
    }
}
