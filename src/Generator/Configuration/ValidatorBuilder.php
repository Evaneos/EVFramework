<?php

namespace EVFramework\Generator\Configuration;

class ValidatorBuilder extends AbstractBuilder
{
    const NAME = 'Validator';

    protected function makeConfiguration($definitionNameTpl, $packageConfiguration, $resourceName)
    {
        $voName = $packageConfiguration['vo'];

        $configuration = array('class' => '\Berthe\Validation\BaseValidator', 'call' => array(
            'setErrors' => array('@FunctionalListException')
        ));

        return $configuration;
    }
}