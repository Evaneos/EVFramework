<?php

namespace EVFramework\Generator\Configuration;

interface Director
{
    function addBuilder(Builder\Builder $builder);
    function build(Builder\Builder $builder, $resourceName);
    function buildAll($resourceName);
}