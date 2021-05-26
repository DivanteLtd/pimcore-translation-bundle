<?php
/**
 * @author Piotr Rugała <piotr@isedo.pl>
 * @copyright Copyright (c) 2021 Divante Ltd. (https://divante.co)
 */

declare(strict_types=1);

namespace DivanteTranslationBundle\Provider;

class DeeplFreeProvider extends DeeplProvider
{
    protected string $url = 'https://api-free.deepl.com/';

    public function getName(): string
    {
        return 'deepl_free';
    }
}
