<?php

namespace EVFramework\Generator\Configuration;

class MemcachedStoreBuilder extends AbstractBuilder
{
    const NAME = 'MemcachedStore';

    protected function makeConfiguration($definitionNameTpl, $packageConfiguration, $resourceName)
    {
        $configuration = array( 'class' => '\Berthe\DAL\StoreMemcached',
                                'arguments' => array('@Memcached'),
                                'call' => array(
                                    'setPrefix' => array('berthe'),
                                    'setName' => array($resourceName),
                                    'setSuffix' => array('all')
        ));

        return $configuration;
    }
}