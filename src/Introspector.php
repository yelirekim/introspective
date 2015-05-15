<?php

namespace Yelirekim\Introspective;

use Closure;

class Introspector
{
    private $providers = [];

    public static function reflect($classname)
    {
        return (new Introspector)
            ->addProvider(new Provider\Reflect)
            ->getClass($classname);
    }

    public function addProvider(Provider\Provider $provider, $priority = 0)
    {
        $this->providers[$priority][] = $provider;

        return $this;
    }

    public function getExternalObjectOperations($classname)
    {
        return $this->getObjectOperations(
            $classname,
            function(Definition\Definition $child, Definition\Definition $parent) use ($classname) {
                return $child->isPublic() && !$child->static;
            });
    }

    public function getInternalObjectOperations($classname)
    {
        return $this->getObjectOperations(
            $classname,
            function(Definition\Definition $child, Definition\Definition $parent) use ($classname) {
                $isPrivate = $child->isPrivate();
                $isVisiblePrivate = $isPrivate && $parent->getNamespacedName() == $classname;
                return !$child->static && (!$isPrivate || $isVisiblePrivate);
            });
    }

    private function getObjectOperations($classname, Closure $filter)
    {
        $operations = [];
        if($class = $this->getClass($classname)) {
            $operations = array_merge(
                $class->filterProperty('methods', $filter),
                $class->filterProperty('properties', $filter)
            );
            if($class->extends !== null) {
                $operations = array_merge($operations, $this->getObjectOperations($class->extends, $filter));
            }
        }

        return $operations;
    }

    public function getClass($classname)
    {
        foreach ($this->providers as $priority => $providers) {
            foreach ($providers as $provider) {
                if($provider->hasClass($classname)) {
                    return $provider->getClass($classname);
                }
            }
        }

        return null;
    }
}
