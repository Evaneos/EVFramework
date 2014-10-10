<?php

namespace EVFramework\Generator\Configuration;

interface Builder
{
    function setContainer($container);
    function build($resouceName);
}