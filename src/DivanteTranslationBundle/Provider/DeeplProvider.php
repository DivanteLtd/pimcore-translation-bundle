<?php
/**
 * @author Piotr Rugała <piotr@isedo.pl>
 * @copyright Copyright (c) 2021 Divante Ltd. (https://divante.co)
 */

declare(strict_types=1);

namespace DivanteTranslationBundle\Provider;

use DivanteTranslationBundle\Exception\TranslationException;

final class DeeplProvider extends AbstractProvider
{
    protected string $url = 'https://api.deepl.com/';

    public function translate(string $data, string $targetLanguage): string
    {
        try {
            $response = $this->getHttpClient()->request(
                'POST',
                'v2/translate',
                [
                    'query' => [
                        'auth_key' => $this->apiKey,
                        'text' => rawurlencode($data),
                        'target_lang' => locale_get_primary_language($targetLanguage),
                    ]
                ]
            );

            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);
        } catch (\Throwable $exception) {
            throw new TranslationException();
        }

        return $data['data']['translations'][0]['text'];
    }

    public function getName(): string
    {
        return 'deepl';
    }
}
