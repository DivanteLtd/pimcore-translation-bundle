<?php
/**
 * @author Piotr Rugała <piotr@isedo.pl>
 * @copyright Copyright (c) 2021 Divante Ltd. (https://divante.co)
 */

declare(strict_types=1);

namespace DivanteTranslationBundle\Exception;

use Throwable;

final class TranslationProviderNotImplemented extends \Exception
{
    public function __construct($provider)
    {
        parent::__construct(sprintf("Provider %s is not implemented.", $provider));
    }
}
