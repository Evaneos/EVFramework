<?php

namespace EVFramework\Berthe\Fetcher;

use Pyrite\PyRest\PyRestConfiguration;

interface FetcherBuilder
{
    /**
     * Return an implementation of a Fetcher based on PyRestConfiguration
     * @param  PyRestConfiguration $config
     * @return \Berthe\Fetcher
     */
    function build(PyRestConfiguration $config);
}
