<?php

namespace EVFramework\Generator\Configuration;

class BuilderBuilder extends AbstractBuilder
{
    const NAME = 'Builder';

    protected function makeConfiguration($definitionNameTpl, $packageConfiguration, $resourceName)
    {
        $validatorName = sprintf($definitionNameTpl, $resourceName, 'Validator');
        $storageName = sprintf($definitionNameTpl, $resourceName, 'Storage');
        $voName = $packageConfiguration['vo'];

        $configuration = array('class' => '\Berthe\BaseBuilder');

        return $configuration;
    }
}