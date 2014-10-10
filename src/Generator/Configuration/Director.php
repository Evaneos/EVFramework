<?php

namespace EVFramework\Generator\Configuration;

interface Director
{
    function addBuilder(Builder $builder);
    function build(Builder $builder, $resourceName);
    function buildAll($resourceName);
}