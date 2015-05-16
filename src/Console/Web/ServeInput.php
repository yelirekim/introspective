<?php

namespace Yelirekim\Introspective\Console\Web;

use Symfony\Component\Console\Input\Input;

class ServeInput extends Input
{
    protected function parse()
    {
        if(!$bootstrap = json_decode($_ENV['bootstrap'])) {
            throw new \RuntimeException('No bootstrapping files have been specified in the environment.');
        }
        $this->setOption('bootstrap', $bootstrap);
        $this->setRequestOption('buffer');
        $this->setRequestOption('row');
        $this->setRequestOption('column');
        $this->setRequestOption('format');
    }

    private function setRequestOption($name)
    {
        if(!isset($_REQUEST[$name]) || !($value = $_REQUEST[$name])) {
            throw new \RuntimeException(sprintf('The %s parameter is empty.', $name));
        }

        $this->setOption($name, $value);
    }

    public function getFirstArgument()
    {
        return null;
    }

    public function hasParameterOption($values)
    {
        return false;
    }

    public function getParameterOption($values, $default = false)
    {
        return $default;
    }
}
