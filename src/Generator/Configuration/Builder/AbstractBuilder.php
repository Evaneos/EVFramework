<?php

namespace EVFramework\Generator\Configuration\Builder;

use EVFramework\Generator\Configuration\DefinitionHelper;
use EVFramework\Generator\Configuration\Definition;

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
        $packageConfiguration = $this->container->getParameter(implode('.', array(Definition::PARAM_PACKAGES, $resourceName)));
        $serviceName = DefinitionHelper::getServiceName($this->container, $resourceName, $this->getDefinitionName());

        if (!self::containerHasPackage($serviceName)) {
            return array($serviceName, $this->makeConfiguration($packageConfiguration, $resourceName));
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

    abstract protected function makeConfiguration($packageConfiguration, $resourceName);
}