<?php

namespace EVFramework\Generator\Configuration\Builder;

use EVFramework\Generator\Configuration\DefinitionHelper;
use EVFramework\Generator\Configuration\Definition;

class WriterBuilder extends AbstractBuilder
{
    const NAME = 'Writer';
    const BASE_CLASS = '\Berthe\DAL\BaseWriter';

    protected function makeConfiguration($packageConfiguration, $resourceName)
    {
        $tableName = $packageConfiguration[Definition::OBJECT_TABLE_NAME];
        $class = DefinitionHelper::getClassImplementation($this->container, $resourceName, static::NAME, static::BASE_CLASS);

        $configuration = array( 'class' => $class,
                                'singleton' => 'true',
                                'call' => array(
                                    'setDb' => array('@DbWriter'),
                                    'setTableName' => array($tableName)
        ));

        return $configuration;
    }
}