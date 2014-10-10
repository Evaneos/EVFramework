<?php

namespace EVFramework\Generator\Configuration;

class ManagerBuilder extends AbstractBuilder
{
    const NAME = 'Manager';

    protected function makeConfiguration($definitionNameTpl, $packageConfiguration, $resourceName)
    {
        $validatorName = sprintf($definitionNameTpl, $resourceName, 'Validator');
        $storageName = sprintf($definitionNameTpl, $resourceName, 'Storage');
        $voName = $packageConfiguration['vo'];

        $configuration = array('class' => '\Berthe\BaseManager', 'call' => array(
            'setValidator' => array('@' . $validatorName),
            'setStorage' => array('@' . $storageName),
            'setVOFQCN' => array($voName)
        ));

        return $configuration;
    }
}