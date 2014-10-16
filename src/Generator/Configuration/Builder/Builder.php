<?php

namespace EVFramework\Generator\Configuration\Builder;

interface Builder
{
    function setContainer($container);
    function build($resouceName);
}