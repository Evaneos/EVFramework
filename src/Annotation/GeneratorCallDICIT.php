<?php

namespace EVFramework\Annotation;

// use Doctrine\Common\Annotations as Doctrine;

/**
 * @Annotation
 * @Target({"METHOD"})
 */
class GeneratorCallDICIT
{
    protected $resource;
    protected $type;

    public function __construct(array $args = array())
    {
        $this->resource = array_key_exists('resource', $args) ? $args['resource'] : null;
        $this->type = array_key_exists('type', $args) ? $args['type'] : null;
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function getType()
    {
        return $this->type;
    }
}
