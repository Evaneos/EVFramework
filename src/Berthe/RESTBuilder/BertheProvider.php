<?php

namespace EVFramework\Berthe\RESTBuilder;

use Pyrite\PyRest\PyRestBuilderProvider;

class BertheProvider implements PyRestBuilderProvider
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getBuilder($resourceName)
    {
        return $this->container->get($this->getServiceName($resourceName, 'RESTBuilder'));
    }

    public function getBuilders()
    {
        $builders = array();
        $packages = $this->container->getParameter('crud.packages');
        foreach ($packages as $resourceName => $config) {
            $builders[$resourceName] = $this->getBuilder($resourceName);
        }
        return $builders;
    }

    protected function getServiceName($resourceName, $serviceName)
    {
        $definitionNameWithPlaceHolders = $this->container->getParameter('crud.configuration.definition_name');
        $resolvedServiceName = sprintf($definitionNameWithPlaceHolders, $resourceName, $serviceName);

        return $resolvedServiceName;
    }
}
