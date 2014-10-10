<?php

namespace EVFramework\Generator\Configuration;

abstract class AbstractBuilder implements Builder
{
    const NAME = 'AbstractBuilder';

    protected $container;

    public function setContainer($container)
    {
        $this->container = $container;
    }

    public function build($resourceName)
    {
        $definitionNameTpl = $this->container->getParameter('crud.configuration.definition_name');
        $packageConfiguration = $this->container->getParameter('crud.packages.' . $resourceName);
        $serviceName = sprintf($definitionNameTpl, $resourceName, $this->getDefinitionName());

        if (!self::containerHasPackage($serviceName)) {
            return array($serviceName, $this->makeConfiguration($definitionNameTpl, $packageConfiguration, $resourceName));
        }

        return array($serviceName, null);
    }

    final protected function getDefinitionName()
    {
        return static::NAME;
    }

    protected function containerHasPackage($packageName)
    {
        return $this->container->has($packageName);
    }

    abstract protected function makeConfiguration($definitionNameTpl, $packageConfiguration, $resourceName);
}