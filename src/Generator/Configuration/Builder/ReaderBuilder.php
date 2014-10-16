<?php

namespace EVFramework\Generator\Configuration\Builder;

use EVFramework\Generator\Configuration\DefinitionHelper;
use EVFramework\Generator\Configuration\Definition;

class ReaderBuilder extends AbstractBuilder
{
    const NAME = 'Reader';
    const BASE_CLASS = '\Berthe\DAL\BaseReader';

    protected function makeConfiguration($packageConfiguration, $resourceName)
    {
        $tableName = $packageConfiguration[Definition::OBJECT_TABLE_NAME];
        $voName = $packageConfiguration[Definition::OBJECT_NAME];
        $class = DefinitionHelper::getClassImplementation($this->container, $resourceName, static::NAME, static::BASE_CLASS);

        $configuration = array( 'class' => $class,
                                'singleton' => 'true',
                                'call' => array(
                                    'setDb' => array('@DbReader'),
                                    'setVOFQCN' => array($voName),
                                    'setTableName' => array($tableName),
                                    'setQueryBuilder' => array('@FetcherPGSQLQueryBuilder')
        ));

        return $configuration;
    }
}