<?php

namespace EVFramework\Generator\Configuration\Builder;

use EVFramework\Generator\Configuration\DefinitionHelper;

class FetcherBuilderBuilder extends AbstractBuilder
{
    const NAME = 'FetcherBuilder';

    const BASE_CLASS = 'EVFramework\Berthe\Fetcher\BaseFetcherBuilder';

    protected function makeConfiguration($packageConfiguration, $resourceName)
    {
        $class = DefinitionHelper::getClassImplementation($this->container, $resourceName, static::NAME, static::BASE_CLASS);

        $configuration = array( 'class' => $class,
                                'singleton' => 'true');

        return $configuration;
    }
}