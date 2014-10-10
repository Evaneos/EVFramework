<?php

namespace EVFramework\PyRest;

use Symfony\Component\HttpFoundation\Request;
use Pyrite\PyRest\RestController;

use Pyrite\PyRest\PyRestConfiguration;
use Pyrite\PyRest\Configuration\ResourceNameParser;
use Pyrite\PyRest\Configuration\ResourceIdParser;
use Pyrite\PyRest\Configuration\PaginationParser;
use Pyrite\PyRest\Configuration\FilterParser;

use Pyrite\Response\ResponseBag;
use Pyrite\Layer\Executor\Executable;
use Berthe\Service;
use EVFramework\Generator\Configuration\Director;
use HelloWorld\Test\VO\User;

class BerthePyRestController
{
    protected $director = null;
    protected $container = null;

    public function setConfigurationDirector(Director $director)
    {
        $this->director = $director;
    }

    public function setContainer($container)
    {
        $this->container = $container;
    }

    protected function getServiceName($resourceName, $serviceName)
    {
        $c = $this->container;
        $definitionNameWithPlaceHolders = $c->getParameter('crud.configuration.definition_name');
        $resolvedServiceName = sprintf($definitionNameWithPlaceHolders, $resourceName, $serviceName);

        return $resolvedServiceName;
    }

    protected function getBertheService($resourceName)
    {
        return $this->container->get($this->getServiceName($resourceName, 'Service'));
    }

    protected function getBertheFetcherBuilder($resourceName)
    {
        return $this->container->get($this->getServiceName($resourceName, 'FetcherBuilder'));
    }

    protected function getBertheBuilder($resourceName)
    {
        return $this->container->get($this->getServiceName($resourceName, 'Builder'));
    }

    public function getAll(Request $request, ResponseBag $bag)
    {
        $restConfiguration = $bag->get('__PyRestConfiguration', new PyRestConfiguration());

        $resourceName = $restConfiguration->getConfig(ResourceNameParser::NAME);
        $service = $this->getBertheService($resourceName);
        $fetcherBuilder = $this->getBertheFetcherBuilder($resourceName);
        $fetcher = $fetcherBuilder->build($restConfiguration);
        $result = $service->getByFetcher($fetcher);

        // run query against DAL
        $bag->set('data', $result->getResultSet());
        $bag->set('count', $result->getTtlCount());

        // post treatment back-end side
        // here

        return $result;
    }

    public function get(Request $request, ResponseBag $bag)
    {
        $restConfiguration = $bag->get('__PyRestConfiguration', new PyRestConfiguration());

        $resourceName = $restConfiguration->getConfig(ResourceNameParser::NAME);
        $resourceId = $restConfiguration->getConfig(ResourceIdParser::NAME);

        $service = $this->getBertheService($resourceName);

        // run query against DAL
        $result = $service->getById($resourceId);

        $bag->set('data', $result);

        // post treatment back-end side
        // here

        return $result;
    }

    public function put(Request $request, ResponseBag $bag)
    {
        throw new \Pyrite\PyRest\Exception\NotImplementedException();
    }

    public function putAll(Request $request, ResponseBag $bag)
    {
        throw new \Pyrite\PyRest\Exception\NotImplementedException();
    }

    public function post(Request $request, ResponseBag $bag)
    {
        throw new \Pyrite\PyRest\Exception\NotImplementedException();
    }

    public function patch(Request $request, ResponseBag $bag)
    {
        throw new \Pyrite\PyRest\Exception\NotImplementedException();
    }

    public function patchAll(Request $request, ResponseBag $bag)
    {
        throw new \Pyrite\PyRest\Exception\NotImplementedException();
    }

    public function delete(Request $request, ResponseBag $bag)
    {
        throw new \Pyrite\PyRest\Exception\NotImplementedException();
    }

    public function deleteAll(Request $request, ResponseBag $bag)
    {
        throw new \Pyrite\PyRest\Exception\NotImplementedException();
    }

    public function options(Request $request, ResponseBag $bag)
    {
        throw new \Pyrite\PyRest\Exception\NotImplementedException();
    }
}