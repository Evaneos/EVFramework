<?php

namespace EVFramework\Generator\Configuration\Builder;

use EVFramework\Generator\Configuration\DefinitionHelper;

class RESTBuilderBuilder extends AbstractBuilder
{
    const NAME = 'RESTBuilder';

    const BASE_CLASS = 'EVFramework\Berthe\RESTBuilder\BaseRESTBuilder';

    protected function makeConfiguration($packageConfiguration, $resourceName)
    {
        $class = DefinitionHelper::getClassImplementation($this->container, $resourceName, static::NAME, static::BASE_CLASS);

        $refClass = new \ReflectionClass($class);
        $methods = $refClass->getMethods();

        $reader = $this->container->get('AnnotationReader');

        $calls = array();
        foreach ($methods as $method) {
            $annotations = $reader->getMethodAnnotations($method);
            foreach ($annotations as $annotation) {
                if ($annotation instanceof \EVFramework\Annotation\GeneratorCallDICIT) {
                    $calls[$method->getName()] = array("@" . DefinitionHelper::getServiceName($this->container, $annotation->getResource(), $annotation->getType()));
                }
            }

            if ($method->getName() == 'setContainer') {
                $calls[$method->getName()] = array('$container');
            }
        }

        $configuration = array( 'class' => $class,
                                'singleton' => 'true',
                                'arguments' => array('$container', $resourceName)
        );

        if (count($calls)) {
            $configuration['call'] = $calls;
        }

        // var_export($configuration);
        // die();
        return $configuration;
    }
}
