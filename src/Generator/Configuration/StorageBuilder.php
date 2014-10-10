<?php

namespace EVFramework\Generator\Configuration;

class StorageBuilder extends AbstractBuilder
{
    const NAME = 'Storage';

    protected function makeConfiguration($definitionNameTpl, $packageConfiguration, $resourceName)
    {
        $pgStoreName = sprintf($definitionNameTpl, $resourceName, 'PersistentStore');
        $memcachedStoreName = sprintf($definitionNameTpl, $resourceName, 'MemcachedStore');

        $configuration = array('class' => '\Berthe\DAL\BaseStorage', 'call' => array(
            // 'addStore[0]' => array('@' . $memcachedStoreName),
            'addStore[1]' => array('@' . $pgStoreName)
        ));

        return $configuration;
    }
}