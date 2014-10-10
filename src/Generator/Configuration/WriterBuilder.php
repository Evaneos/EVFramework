<?php

namespace EVFramework\Generator\Configuration;

class WriterBuilder extends AbstractBuilder
{
    const NAME = 'Writer';

    protected function makeConfiguration($definitionNameTpl, $packageConfiguration, $resourceName)
    {
        $tableName = $packageConfiguration['table'];

        $configuration = array('class' => '\Berthe\DAL\BaseWriter', 'call' => array(
            'setDb' => array('@DbWriter'),
            'setTableName' => array($tableName)
        ));

        return $configuration;
    }
}