<?php

namespace Yelirekim\Introspective\Provider\Traversal;

use PhpParser;
use Closure;

class ClosureNodeVisitor implements PhpParser\NodeVisitor
{
    private $beforeTraverse;
    private $enterNode;
    private $leaveNode;
    private $afterTraverse;

    public function __construct(
        Closure $beforeTraverse = null,
        Closure $enterNode = null,
        Closure $leaveNode = null,
        Closure $afterTraverse = null
    ) {
        $this->beforeTraverse = $beforeTraverse;
        $this->enterNode = $enterNode;
        $this->leaveNode = $leaveNode;
        $this->afterTraverse = $afterTraverse;
    }

    public function beforeTraverse(array $nodes)
    {
        return $this->call('beforeTraverse', $nodes);
    }

    public function enterNode(PhpParser\Node $node)
    {
        return $this->call('enterNode', $node);
    }

    public function leaveNode(PhpParser\Node $node)
    {
        return $this->call('leaveNode', $node);
    }

    public function afterTraverse(array $nodes)
    {
        return $this->call('afterTraverse', $nodes);
    }

    public static function before(Closure $callback)
    {
        return static::factory($callback, 0);
    }

    public static function enter(Closure $callback)
    {
        return static::factory($callback, 1);
    }

    public static function leave(Closure $callback)
    {
        return static::factory($callback, 2);
    }

    public static function after(Closure $callback)
    {
        return static::factory($callback, 3);
    }

    private static function factory(Closure $callback, $index)
    {
        $args = [null, null, null, null];
        $args[$index] = $callback;
        return (new \ReflectionClass(get_called_class()))->newInstanceArgs($args);
    }

    private function call($method, $args)
    {
        if(($closure = $this->$method)) {
            return $closure($args);
        }

        return null;
    }
}
