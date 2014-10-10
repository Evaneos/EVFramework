<?php

namespace EVFramework\Generator\Configuration;

class ComposerBuilder extends AbstractBuilder
{
    const NAME = 'Composer';

    protected function makeConfiguration($definitionNameTpl, $packageConfiguration, $resourceName)
    {
        $configuration = array('class' => 'Berthe\Composition\IdentityComposer');

        return $configuration;
    }
}