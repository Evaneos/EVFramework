<?php

namespace EVFramework\Generator\Configuration;

class ReaderBuilder extends AbstractBuilder
{
    const NAME = 'Reader';

    protected function makeConfiguration($definitionNameTpl, $packageConfiguration, $resourceName)
    {
        $tableName = $packageConfiguration['table'];
        $voName = $packageConfiguration['vo'];

        $configuration = array('class' => '\Berthe\DAL\BaseReader', 'call' => array(
            'setDb' => array('@DbReader'),
            'setVOFQCN' => array($voName),
            'setTableName' => array($tableName),
            'setQueryBuilder' => array('@FetcherPGSQLQueryBuilder')
        ));

        return $configuration;
    }
}