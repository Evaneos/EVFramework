<?php

namespace EVFramework\Generator\Configuration\Builder;

use EVFramework\Generator\Configuration\DefinitionHelper;
use EVFramework\Generator\Configuration\Definition;

class BuilderBuilder extends AbstractBuilder
{
    const NAME = 'Builder';

    const BASE_CLASS = '\Berthe\BaseBuilder';

    protected function makeConfiguration($packageConfiguration, $resourceName)
    {
        $validatorName = DefinitionHelper::getServiceName($this->container, $resourceName, ValidatorBuilder::NAME);
        $storageName = DefinitionHelper::getServiceName($this->container, $resourceName, StorageBuilder::NAME);
        $voName = $packageConfiguration[Definition::OBJECT_NAME];
        $class = DefinitionHelper::getClassImplementation($this->container, $resourceName, static::NAME, static::BASE_CLASS);

        $configuration = array( 'class' => $class,
                                'singleton' => 'true');

        return $configuration;
    }
}