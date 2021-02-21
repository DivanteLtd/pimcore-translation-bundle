<?php
/**
 * @author Piotr Rugała <piotr@isedo.pl>
 * @copyright Copyright (c) 2021 Divante Ltd. (https://divante.co)
 */

declare(strict_types=1);

namespace DivanteTranslateBundle\Provider;

use DivanteTranslateBundle\Exception\TranslationException;

class DeeplProvider extends AbstractProvider
{
    protected string $url = 'https://api.deepl.com/v2/translate';

    public function translate(string $data, string $targetLanguage): string
    {
        try {
            $response = $this->getHttpClient()->request('POST', [
                'query' => [
                    'auth_key' => $this->apiKey,
                    'text' => rawurlencode($data),
                    'target_lang' => locale_get_primary_language($targetLanguage),
                ]
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);
        } catch (\Throwable $exception) {
            throw new TranslationException();
        }

        return $data['data']['translations'][0]['text'];
    }

    public function getName(): string
    {
        return 'google_translate';
    }
}
