<?php

namespace EVFramework\Generator\Configuration;

class DirectorInjectorDecorator implements Director
{
    protected $container = null;
    protected $wrapped = null;

    public function __construct(\Pyrite\Container\Container $container, $director)
    {
        $this->container = $container;
        $this->wrapped = $director;
    }

    public function addBuilder(Builder $builder)
    {
        return $this->wrapped->addBuilder($builder);
    }

    public function build(Builder $builder, $resourceName)
    {
        $result = $this->wrapped->build($builder, $resourceName);
        list($class, $configuration) = $result;
        if ($configuration && is_array($configuration) && count($configuration)) {
            $this->container->bind($class, $configuration);
        }

        return $result;
    }

    public function buildAll($resourceName)
    {
        $results = $this->wrapped->buildAll($resourceName);
        foreach($results as $class => $configuration) {
            if ($configuration && is_array($configuration) && count($configuration)) {
                $this->container->bind($class, $configuration);
            }
        }

        return $results;
    }
}