<?php
/**
 * @author Piotr Rugała <piotr@isedo.pl>
 * @copyright Copyright (c) 2021 Divante Ltd. (https://divante.co)
 */

declare(strict_types=1);

namespace DivanteTranslationBundle\Provider;

use DivanteTranslationBundle\Exception\TranslationException;

class GoogleProvider extends AbstractProvider
{
    protected string $url = 'https://www.googleapis.com/language/translate/v2';

    public function translate(string $data, string $targetLanguage): string
    {
        try {
            $response = $this->getHttpClient()->request('GET', [
                'query' => [
                    'key' => $this->apiKey,
                    'q' => rawurlencode($data),
                    'source' => '',
                    'target' => locale_get_primary_language($targetLanguage),
                ]
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);

            if ($data['error']) {
                throw new TranslationException();
            }
        } catch (\Throwable $exception) {
            throw new TranslationException();
        }

        return $data['data']['translations'][0]['translatedText'];
    }

    public function getName(): string
    {
        return 'google_translate';
    }
}
