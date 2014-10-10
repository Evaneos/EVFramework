<?php

namespace EVFramework\Generator\Configuration;

class TransformerBuilder extends AbstractBuilder
{
    const NAME = 'Transformer';

    protected function makeConfiguration($definitionNameTpl, $packageConfiguration, $resourceName)
    {
        $configuration = array('class' => 'Evaneos\Api\Rest\Transformers\BaseTransformer');

        return $configuration;
    }
}