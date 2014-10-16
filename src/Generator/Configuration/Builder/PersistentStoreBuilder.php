<?php

namespace EVFramework\Generator\Configuration\Builder;

use EVFramework\Generator\Configuration\DefinitionHelper;

class PersistentStoreBuilder extends AbstractBuilder
{
    const NAME = 'PersistentStore';
    const BASE_CLASS = '\Berthe\DAL\StoreDatabase';

    protected function makeConfiguration($packageConfiguration, $resourceName)
    {
        $readerName = DefinitionHelper::getServiceName($this->container, $resourceName, ReaderBuilder::NAME);
        $writerName = DefinitionHelper::getServiceName($this->container, $resourceName, WriterBuilder::NAME);
        $class = DefinitionHelper::getClassImplementation($this->container, $resourceName, static::NAME, static::BASE_CLASS);

        $configuration = array( 'class' => $class,
                                'singleton' => 'true',
                                'call' => array(
                                    'setReader' => array('@' . $readerName),
                                    'setWriter' => array('@' . $writerName)
        ));

        return $configuration;
    }
}