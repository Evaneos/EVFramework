<?php

namespace EVFramework\Generator\Configuration;

interface Director
{
    public function addBuilder(Builder\Builder $builder);
    public function build(Builder\Builder $builder, $resourceName);
    public function buildAll($resourceName);
}
