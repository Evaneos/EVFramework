<?php

namespace EVFramework\Generator\Configuration\Builder;

use EVFramework\Generator\Configuration\DefinitionHelper;


class RESTBuilderBuilder extends AbstractBuilder
{
    const NAME = 'RESTBuilder';

    const BASE_CLASS = 'EVFramework\Berthe\RESTBuilder\BaseRESTBuilder';

    protected function makeConfiguration($packageConfiguration, $resourceName)
    {
        $class = DefinitionHelper::getClassImplementation($this->container, $resourceName, static::NAME, static::BASE_CLASS);

        $configuration = array( 'class' => $class,
                                'singleton' => 'true',
                                'arguments' => array('$container', $resourceName)
        );

        return $configuration;
    }
}