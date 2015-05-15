<?php

namespace Yelirekim\Introspective\Definition;

trait HasVisibility
{
    public $static = false;
    public $visibility = 'public';

    public function isPublic()
    {
        return $this->visibility === 'public';
    }

    public function isPrivate()
    {
        return $this->visibility === 'private';
    }

    public function isProtected()
    {
        return $this->visibility === 'protected';
    }
}
