<?php

namespace EVFramework\Generator\Configuration;

class PersistentStoreBuilder extends AbstractBuilder
{
    const NAME = 'PersistentStore';

    protected function makeConfiguration($definitionNameTpl, $packageConfiguration, $resourceName)
    {
        $readerName = sprintf($definitionNameTpl, $resourceName, 'Reader');
        $writerName = sprintf($definitionNameTpl, $resourceName, 'Writer');

        $configuration = array('class' => '\Berthe\DAL\StoreDatabase', 'call' => array(
            'setReader' => array('@' . $readerName),
            'setWriter' => array('@' . $writerName)
        ));

        return $configuration;
    }
}