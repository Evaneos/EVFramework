<?php

namespace EVFramework\Generator\Configuration\Builder;

interface Builder
{
    public function setContainer($container);
    public function build($resouceName);
}
