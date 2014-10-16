<?php

namespace EVFramework\Berthe\RESTBuilder;

use EVFramework\Generator\Configuration\Definition;
use EVFramework\Generator\Configuration\DefinitionHelper;

class BaseRESTBuilder
{
    protected $container = null;
    protected $resourceName = null;

    public function __construct($container, $resourceName)
    {
        $this->container = $container;
        $this->resourceName = $resourceName;
    }

    protected function preBuild($object)
    {
        $classNameREST = DefinitionHelper::getClassImplementation($this->container, $this->resourceName, 'REST', null);
        $objectREST = new $classNameREST($object);
        return $objectREST;
    }

    public function convertAll(array $objects = array(), $resourceName = null, array $embeds = array())
    {
        $objectsREST = array();
        foreach($objects as $key => $object) {
            $objectREST = $this->preBuild($object);
            $objectsREST[$key] = $objectREST;
        }
        $this->joinBuild($objects, $objectsREST, $embeds);

        return $objectsREST;
    }

    private function joinBuild(array $objects = array(), array $objectsREST = array(), array $embeds = array())
    {
        $count = count($objects);
        if(!$count) {
            return;
        }

        $first = reset($objectsREST);
        $embeddables = $first::getEmbeddables();
        $parentResourceName = $first::RESOURCE_NAME;

        foreach($embeds as $name => $embedArray) {
            if (array_key_exists($name, $embeddables)) {
                if ($embeddables[$name] instanceof \Pyrite\PyRest\PyRestItem || $embeddables[$name] instanceof \Pyrite\PyRest\PyRestProperty) {
                    $joinMethod = "join" . ucfirst($name);
                    if (method_exists($this, $joinMethod)) {
                        $this->$joinMethod($objects, $objectsREST, $embedArray);
                    }
                    else {
                        throw new \Pyrite\PyRest\Exception\NotImplementedException(sprintf("Couldn't embed '%s', method '%s' doesn't exist in '%s'", $name, $joinMethod, get_class($this)));
                    }
                }
                elseif ($embeddables[$name] instanceof \Pyrite\PyRest\PyRestCollection) {
                    throw new \Pyrite\PyRest\Exception\BadRequestException(sprintf("Embed a collection is forbidden, tried to embed '%s'", $name, $parentResourceName));
                }
                else {
                    throw new \Pyrite\PyRest\Exception\BadRequestException(sprintf("Can only embed a PyRestItem, '%s' is a '%s'", $name, gettype($embeddables[$name])));
                }
            }
            else {
                throw new \Pyrite\PyRest\Exception\BadRequestException(sprintf("'%s' is not an available embed", $name));

            }
        }
    }

    protected function bind(array $a = array(), array $aREST = array(), array $b = array(), array $bREST = array(), $embedName, \Closure $fn)
    {
        foreach($a as $aKey => $aValue) {
            foreach($b as $bKey => $bValue) {
                if ($fn($aValue, $bValue)) {
                    $aRestObject = $aREST[$aKey];
                    $aRestObject->pushInEmbed($embedName, $bREST[$bKey]);
                    return true;
                }
            }
        }
    }
}