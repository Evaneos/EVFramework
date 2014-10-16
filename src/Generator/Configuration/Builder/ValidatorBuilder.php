<?php

namespace EVFramework\Generator\Configuration\Builder;

use EVFramework\Generator\Configuration\DefinitionHelper;
use EVFramework\Generator\Configuration\Definition;

class ValidatorBuilder extends AbstractBuilder
{
    const NAME = 'Validator';
    const BASE_CLASS = '\Berthe\Validation\BaseValidator';

    protected function makeConfiguration($packageConfiguration, $resourceName)
    {
        $voName = $packageConfiguration[Definition::OBJECT_NAME];
        $class = DefinitionHelper::getClassImplementation($this->container, $resourceName, static::NAME, static::BASE_CLASS);

        $configuration = array( 'class' => $class,
                                'singleton' => 'true',
                                'call' => array(
                                    'setErrors' => array('@FunctionalListException')
        ));

        return $configuration;
    }
}