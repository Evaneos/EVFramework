<?php

namespace EVFramework\Berthe\Fetcher;

use Pyrite\PyRest\PyRestConfiguration;
use Pyrite\PyRest\Configuration\PaginationParser;
use Pyrite\PyRest\Configuration\FilterParser;
use Berthe\Fetcher;
use Pyrite\PyRest\Exception\NotImplementedException;
use Pyrite\PyRest\Exception\BadRequestException;

class BaseFetcherBuilder implements FetcherBuilder
{
    /**
     * Return a Fetcher for the given PyRestConfiguration
     * @param  PyRestConfiguration $config
     * @return Fetcher
     */
    public function build(PyRestConfiguration $config)
    {
        $fetcher = $this->createFetcher($config);
        $this->createParentResourceFilter($fetcher, $config);
        $this->createFilters($fetcher, $config);
        $this->createSorts($fetcher, $config);
        return $fetcher;
    }

    /**
     * Return the current page
     * @param  PyRestConfiguration $config
     * @return int
     */
    protected function getPage(PyRestConfiguration $config)
    {
        $cfg = $config->getConfig(PaginationParser::NAME, array(
            PaginationParser::KEY_PAGE => PaginationParser::DEFAULT_PAGE,
            PaginationParser::KEY_NBBYPAGE => PaginationParser::DEFAULT_NB_RESULT_PER_PAGE)
        );

        return $cfg[PaginationParser::KEY_PAGE];
    }

    /**
     * Return the number of elements to fetch
     * @param  PyRestConfiguration $config
     * @return int
     */
    protected function getNbByPage(PyRestConfiguration $config)
    {
        $cfg = $config->getConfig(PaginationParser::NAME, array(
            PaginationParser::KEY_PAGE => PaginationParser::DEFAULT_PAGE,
            PaginationParser::KEY_NBBYPAGE => PaginationParser::DEFAULT_NB_RESULT_PER_PAGE)
        );

        return $cfg[PaginationParser::KEY_NBBYPAGE];
    }

    /**
     * Return an instance of Fetcher
     * @param  PyRestConfiguration $config
     * @return Fetcher
     */
    protected function createFetcher(PyRestConfiguration $config)
    {
        return new Fetcher($this->getPage($config), $this->getNbByPage($config));
    }

    /**
     * Add filters for the fetcher
     * @param  Fetcher             $fetcher
     * @param  PyRestConfiguration $config
     * @return void
     */
    protected function createParentResourceFilter(Fetcher $fetcher, PyRestConfiguration $config)
    {
        $parameters = $config->getConfig(FilterParser::NAME, array());
        if (array_key_exists(FilterParser::FILTER_BY_RESOURCE_NAME, $parameters)) {
            $by = $parameters[FilterParser::FILTER_BY_RESOURCE_NAME];

            $nested = $config->getRequest()->attributes->get('nested', null);
            if (!$nested) {
                throw new BadRequestException(sprintf("Couldn't filter nested resource without its name"));
            }

            $methodName = 'filter' . ucfirst($nested) . 'ByIdOfResource' . ucfirst($by);

            if (method_exists($this, $methodName)) {
                $this->$methodName($fetcher, $parameters[FilterParser::FILTER_BY_RESOURCE_ID]);
            } else {
                throw new NotImplementedException(
                    sprintf("Couldn't filter resource by its parent '%s', method '%s' not implemented in '%s'",
                        $by,
                        $methodName,
                        get_class($this)));
            }
        }
    }

    /**
     * Add filters for the fetcher
     * @param  Fetcher             $fetcher
     * @param  PyRestConfiguration $config
     * @return void
     */
    protected function createFilters(Fetcher $fetcher, PyRestConfiguration $config)
    {
        // @OVERRIDE
    }

    /**
     * Add sorts for the fetcher
     * @param  Fetcher             $fetcher
     * @param  PyRestConfiguration $config
     * @return void
     */
    protected function createSorts(Fetcher $fetcher, PyRestConfiguration $config)
    {
        // @OVERRIDE
    }
}
