<?php

namespace EVFramework\Generator\Configuration;

class FetcherBuilderBuilder extends AbstractBuilder
{
    const NAME = 'FetcherBuilder';

    protected function makeConfiguration($definitionNameTpl, $packageConfiguration, $resourceName)
    {
        $configuration = array('class' => 'EVFramework\Berthe\Fetcher\BaseFetcherBuilder');

        return $configuration;
    }
}