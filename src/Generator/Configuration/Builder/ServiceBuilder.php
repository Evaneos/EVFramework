<?php

namespace EVFramework\Generator\Configuration\Builder;

use EVFramework\Generator\Configuration\DefinitionHelper;
use EVFramework\Generator\Configuration\Definition;

class ServiceBuilder extends AbstractBuilder
{
    const NAME = 'Service';
    const BASE_CLASS = '\Berthe\BaseService';

    protected function makeConfiguration($packageConfiguration, $resourceName)
    {
        $managerName = DefinitionHelper::getServiceName($this->container, $resourceName, ManagerBuilder::NAME);
        $builderName = DefinitionHelper::getServiceName($this->container, $resourceName, BuilderBuilder::NAME);
        $class = DefinitionHelper::getClassImplementation($this->container, $resourceName, static::NAME, static::BASE_CLASS);

        $configuration = array('class' => $class,
                                'singleton' => 'true',
                                'arguments' => array('@' . $managerName,
                                                     '@' . $builderName));
        return $configuration;
    }
}
