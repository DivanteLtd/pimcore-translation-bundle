<?php
/**
 * @date        03/10/2019 11:08
 * @author      Łukasz Marszałek <lmarszalek@divante.co>
 * @copyright   Copyright (c) 2019 Divante Ltd. (https://divante.co)
 */
namespace GoogleTranslationBundle\Service;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ConfigurationService
 * @package GoogleTranslationBundle\Service
 */
final class ConfigurationService implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * ConfigurationService constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    /**
     * @return string
     */
    public function getSourceLang()
    {
        return $this->container->getParameter('divante_google_translation.source_lang');
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->container->getParameter('divante_google_translation.api_key');
    }
}
