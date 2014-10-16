<?php

namespace EVFramework\Generator\Configuration\Builder;

use EVFramework\Generator\Configuration\DefinitionHelper;

class MemcachedStoreBuilder extends AbstractBuilder
{
    const NAME = 'MemcachedStore';
    const BASE_CLASS = '\Berthe\DAL\StoreMemcached';

    protected function makeConfiguration($packageConfiguration, $resourceName)
    {
        $class = DefinitionHelper::getClassImplementation($this->container, $resourceName, static::NAME, static::BASE_CLASS);

        $configuration = array( 'class' => $class,
                                'arguments' => array('@Memcached'),
                                'singleton' => 'true',
                                'call' => array(
                                    'setPrefix' => array('berthe'),
                                    'setName' => array($resourceName),
                                    'setSuffix' => array('all')
        ));

        return $configuration;
    }
}