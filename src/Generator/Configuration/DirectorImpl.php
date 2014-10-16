<?php

namespace EVFramework\Generator\Configuration;

class DirectorImpl implements Director
{
    protected $builders = array();
    protected $container = null;

    public function __construct(\Pyrite\Container\Container $container)
    {
        $this->container = $container;
    }

    public function addBuilder(Builder\Builder $builder)
    {
        $this->builders[] = $builder;
    }

    public function build(Builder\Builder $builder, $resourceName)
    {
        $builder->setContainer($this->container);
        return $builder->build($resourceName);
    }

    public function buildAll($resourceName)
    {
        $output = array();
        foreach($this->builders as $builder) {
            list($class, $configuration) = $this->build($builder, $resourceName);
            $output[$class] = $configuration;
        }

        return $output;
    }
}