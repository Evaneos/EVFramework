<?php

namespace EVFramework\Generator\Configuration\Builder;

use EVFramework\Generator\Configuration\DefinitionHelper;
use EVFramework\Generator\Configuration\Definition;

class ManagerBuilder extends AbstractBuilder
{
    const NAME = 'Manager';
    const BASE_CLASS = '\Berthe\BaseManager';

    protected function makeConfiguration($packageConfiguration, $resourceName)
    {
        $validatorName = DefinitionHelper::getServiceName($this->container, $resourceName, ValidatorBuilder::NAME);
        $storageName = DefinitionHelper::getServiceName($this->container, $resourceName, StorageBuilder::NAME);
        $voName = $packageConfiguration[Definition::OBJECT_NAME];
        $class = DefinitionHelper::getClassImplementation($this->container, $resourceName, static::NAME, static::BASE_CLASS);


        $configuration = array( 'class' => $class,
                                'singleton' => 'true',
                                'call' => array(
                                    'setValidator'  => array('@' . $validatorName),
                                    'setStorage'    => array('@' . $storageName),
                                    'setVOFQCN'     => array($voName)
        ));

        return $configuration;
    }
}