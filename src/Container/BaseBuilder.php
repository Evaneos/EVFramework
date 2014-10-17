<?php

namespace EVFramework\Container;

use DICIT\ActivatorFactory;
use DICIT\Config\PHP;
use DICIT\Config\YML;
use Pyrite\Config\NullConfig;
use Symfony\Component\HttpFoundation\Request;

class BaseBuilder
{
    /**
     * Return a DIC-IT container, using adapter to respect Pyrite interface.
     *
     * @param Request $request       Current request object.
     * @param string  $containerPath Path to load config from.
     *
     * @return \Pyrite\Container\Container
     */
    public static function build(Request $request, $containerPath)
    {
        $config = new NullConfig();

        if (null !== $containerPath && preg_match('/.*yml$/', $containerPath)) {
            $config = new YML($containerPath);
        }

        if (null !== $containerPath && preg_match('/.*php$/', $containerPath)) {
            $config = new PHP($containerPath);
        }

        $activator = new ActivatorFactory();
        $container = new DICITAdapter($config, $activator);
        $activator->addActivator('security', $container->get('SecurityActivator'), false);

        // initialize the translation engine
        $translationManager = $container->get('TranslationEngine');
        $host               = $request->getHttpHost();
        $locale             = $container->getParameter('default_locale.' . str_replace('.', '_', $host));

        if ($locale === null) {
            $locale = $container->getParameter('default_locale.default');
        }

        $container->setParameter('current_locale', $locale);

        $translationManager->setLocale($locale);


        $reader = new \Doctrine\Common\Annotations\AnnotationReader();
        \Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(function($class) { return class_exists($class); });
        $container->bind('AnnotationReader', $reader);


        $director = $container->get('PyRestDirector');
        $packages = $container->getParameter('crud.packages');

        foreach($packages as $packageName => $packageConfiguration) {
            $director->buildAll($packageName);
        }

        return $container;
    }
}
