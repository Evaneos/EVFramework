<?php

namespace EVFramework\Generator\Configuration\Builder;

use EVFramework\Generator\Configuration\DefinitionHelper;

class StorageBuilder extends AbstractBuilder
{
    const NAME = 'Storage';
    const BASE_CLASS = '\Berthe\DAL\BaseStorage';

    protected function makeConfiguration($packageConfiguration, $resourceName)
    {
        $pgStoreName = DefinitionHelper::getServiceName($this->container, $resourceName, 'PersistentStore');
        $memcachedStoreName = DefinitionHelper::getServiceName($this->container, $resourceName, 'MemcachedStore');
        $class = DefinitionHelper::getClassImplementation($this->container, $resourceName, static::NAME, static::BASE_CLASS);

        $configuration = array( 'class' => $class,
                                'singleton' => 'true',
                                'call' => array(
                                    // 'addStore[0]' => array('@' . $memcachedStoreName),
                                    'addStore[1]' => array('@' . $pgStoreName)
        ));

        return $configuration;
    }
}