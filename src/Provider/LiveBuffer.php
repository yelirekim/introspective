<?php

namespace Yelirekim\Introspective\Provider;

use PhpParser;
use Closure;
use Yelirekim\Introspective\Definition;

class LiveBuffer extends Provider
{
    private $buffer;
    private $parser;
    private $statements = null;
    private $classNodes = null;
    private $namespace = null;
    private $lines;

    public function __construct($buffer, PhpParser\Lexer $lexer = null)
    {
        $this->buffer = $buffer;
        $this->parser = new PhpParser\Parser($lexer ?: new PhpParser\Lexer\Emulative([
            'usedAttributes' => [
                'comments',
                'startLine',
                'endLine',
                'startTokenPos',
                'endTokenPos',
                'startFilePos', 
                'endFilePos',
            ],
        ]), [
            'throwOnError' => false,
        ]);
        $this->lines = explode(PHP_EOL, $buffer);
    }

    public function getRow($index)
    {
        return isset($this->lines[--$index]) ? $this->lines[$index] : null;
    }

    public function parse()
    {
        try {
            $this->statements = $this->parser->parse($this->buffer);
        } catch (PhpParser\Error $e) {
            $this->statements = [];
            return false;
        }
        return true;
    }

    private function statements()
    {
        if($this->statements === null) {
            $this->parse();
        }

        return $this->statements;
    }

    private function classNodes($classname = null)
    {
        if($this->classNodes === null) {
            $this->findClassNodes();
        }

        if($classname === null) {
            return $this->classNodes;
        }

        $classname = $this->normalizeClassname($classname);

        return isset($this->classNodes[$classname]) ? $this->classNodes[$classname] : null;
    }

    public function getEnclosingClassname($cursorRow, $cursorColumn)
    {
        foreach($this->classNodes() as $classname => $node) {
            $attributes = $node->getAttributes();
            if($cursorRow > $attributes['startLine'] && $cursorRow < $attributes['endLine']) {
                return $classname;
            }
        }

        return null;
    }

    public function getClass($classname)
    {
        if(($node = $this->classNodes($classname))) {
            return (new Definition\Hydrator\PhpParserHydrator)->class_($node);
        }

        return null;
    }

    public function hasClass($classname)
    {
        return $this->classNodes($classname) !== null;
    }

    private function findClassNodes()
    {
        $this->classNodes = [];
        $this->leaveNodes(function(PhpParser\Node $node) {
            if($node instanceof PhpParser\Node\Stmt\Class_) {
                $this->classNodes[$this->getClassname($node)] = $node;
            }
        });
    }

    private function getClassname(PhpParser\Node\Stmt\Class_ $node)
    {
        return $this->normalizeClassname($this->getNamespace() . '\\' . $node->name);
    }

    public function getNamespace()
    {
        if($this->namespace === null) {
            $this->findNamespace();
        }

        return $this->namespace;
    }

    private function findNamespace()
    {
        $this->leaveNodes(function(PhpParser\Node $node) {
            if($node instanceof PhpParser\Node\Stmt\Namespace_) {
                $this->namespace = $node->name ? $node->name->__toString() : '';
            }
        });
    }

    private function leaveNodes(Closure $callback)
    {
        $callback->bindTo($this);
        $traverser = new PhpParser\NodeTraverser;
        $traverser->addVisitor(new PhpParser\NodeVisitor\NameResolver);
        $traverser->addVisitor(Traversal\ClosureNodeVisitor::leave($callback));
        $traverser->traverse($this->statements());
    }
}
