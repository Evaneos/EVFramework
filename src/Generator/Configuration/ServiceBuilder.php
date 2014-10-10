<?php

namespace EVFramework\Generator\Configuration;

class ServiceBuilder extends AbstractBuilder
{
    const NAME = 'Service';

    protected function makeConfiguration($definitionNameTpl, $packageConfiguration, $resourceName)
    {
        $managerName = sprintf($definitionNameTpl, $resourceName, 'Manager');
        $builderName = sprintf($definitionNameTpl, $resourceName, 'Builder');

        $configuration = array('class' => '\Berthe\BaseService', 'arguments' => array('@' . $managerName, '@' . $builderName));
        return $configuration;
    }
}