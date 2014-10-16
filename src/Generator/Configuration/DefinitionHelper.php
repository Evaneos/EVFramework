<?php

namespace EVFramework\Generator\Configuration;


class DefinitionHelper
{
    public static function getServiceName($container, $resourceName, $serviceName)
    {
        $definitionNameWithPlaceHolders = $container->getParameter(Definition::PARAM_CFG_DEF_TPL);
        $resolvedServiceName = sprintf($definitionNameWithPlaceHolders, $resourceName, $serviceName);

        return $resolvedServiceName;
    }

    public static function get($container, $resource, $serviceType)
    {
        $resolvedName = self::getServiceName($container, $resource, $serviceType);
        return $container->get($resolvedName);
    }

    public static function getClassImplementation($container, $resource, $serviceType, $defaultImpl)
    {
        $ns = rtrim($container->getParameter(Definition::PARAM_NAMESPACE), "\\");
        $resourceConfiguration = $container->getParameter(implode('.', array(Definition::PARAM_PACKAGES, $resource)));
        $keyMainName = $resourceConfiguration[Definition::OBJECT_MAIN_NAME];
        $clazz = implode("\\", array($ns, $serviceType, $keyMainName . $serviceType));
        if(class_exists($clazz)) {
            return $clazz;
        }
        else {
            return $defaultImpl;
        }
    }
}