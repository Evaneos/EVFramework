<?php

namespace EVFramework\Berthe\RESTBuilder;

use Pyrite\PyRest\Exception\NotImplementedException;
use Pyrite\PyRest\Exception\BadRequestException;
use Pyrite\PyRest\PyRestBuilder;
use Pyrite\PyRest\Type\PyRestItem;
use Pyrite\PyRest\Type\PyRestProperty;
use Pyrite\PyRest\Type\PyRestCollection;
use EVFramework\Generator\Configuration\Definition;
use EVFramework\Generator\Configuration\DefinitionHelper;

class BaseRESTBuilder implements PyRestBuilder
{
    protected $container = null;
    protected $resourceName = null;

    public function __construct($container, $resourceName)
    {
        $this->container = $container;
        $this->resourceName = $resourceName;
    }

    public function getRESTFQCNImplementation()
    {
        $class = DefinitionHelper::getClassImplementation($this->container, $this->resourceName, 'REST', null);
        if (!$class) {
            throw new NotImplementedException('REST object for resource ' . $this->resourceName . ' not implemented');
        } else {
            return $class;
        }
    }

    protected function preBuild($object)
    {
        $classNameREST = $this->getRESTFQCNImplementation();
        $objectREST = new $classNameREST($object);
        return $objectREST;
    }

    public function convertAll(array $objects = array(), $resourceName = null, array $embeds = array())
    {
        $objectsREST = array();
        foreach ($objects as $key => $object) {
            $objectREST = $this->preBuild($object);
            $objectsREST[$key] = $objectREST;
        }
        $this->joinBuild($objects, $objectsREST, $embeds);

        return $objectsREST;
    }

    private function joinBuild(array $objects = array(), array $objectsREST = array(), array $embeds = array())
    {
        $count = count($objects);
        if (!$count) {
            return;
        }

        $first = reset($objectsREST);
        $embeddables = $first::getEmbeddables();
        $parentResourceName = $first::RESOURCE_NAME;

        foreach ($embeds as $name => $embedArray) {
            if (array_key_exists($name, $embeddables)) {
                if ($embeddables[$name] instanceof PyRestItem || $embeddables[$name] instanceof PyRestProperty) {
                    $joinMethod = "join" . ucfirst($name);
                    if (method_exists($this, $joinMethod)) {
                        $this->$joinMethod($objects, $objectsREST, $embedArray);
                    } else {
                        throw new NotImplementedException(sprintf("Couldn't embed '%s', method '%s' doesn't exist in '%s'", $name, $joinMethod, get_class($this)));
                    }
                } elseif ($embeddables[$name] instanceof PyRestCollection) {
                    throw new BadRequestException(sprintf("Embed a collection is forbidden, tried to embed '%s'", $name, $parentResourceName));
                } else {
                    throw new BadRequestException(sprintf("Can only embed a PyRestItem, '%s' is a '%s'", $name, gettype($embeddables[$name])));
                }
            } else {
                throw new BadRequestException(sprintf("'%s' is not an available embed", $name));
            }
        }
    }

    protected function bind(array $a = array(), array $aREST = array(), array $b = array(), array $bREST = array(), $embedName, \Closure $fn)
    {
        foreach ($a as $aKey => $aValue) {
            foreach ($b as $bKey => $bValue) {
                if ($fn($aValue, $bValue)) {
                    $aRestObject = $aREST[$aKey];
                    $aRestObject->pushInEmbed($embedName, $bREST[$bKey]);
                    return true;
                }
            }
        }
    }

    protected function extractProperty(array $objects = array(), $callable)
    {
        $out = array();
        foreach ($objects as $object) {
            if (is_object($object)) {
                $out[] = $object->$callable();
            }
        }
        return $out;
    }
}
