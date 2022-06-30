<?php

/**
 * @author Piotr Rugała <piotr@isedo.pl>
 * @copyright Copyright (c) 2021 Divante Ltd. (https://divante.co)
 */

declare(strict_types=1);

namespace DivanteTranslationBundle\Provider;

use DivanteTranslationBundle\Exception\TranslationException;

class DeeplProvider extends AbstractProvider implements FormalityProviderInterface
{
    protected string $url = 'https://api.deepl.com/';
    protected string $formality = 'default';

    public function setFormality(?string $formality): self
    {
        $this->formality = $formality ?? $this->formality;

        return $this;
    }
    public function setGlossaryId($glossaryId): self
    {
        $this->glossaryId = $glossaryId;

        return $this;
    }
    public function translate(string $data, string $targetLanguage): string
    {
        try {
            $response = $this->getHttpClient()->request(
                'POST',
                'v2/translate',
                [
                    'query' => [
                        'source_lang' => 'EN',
                        'auth_key' => $this->apiKey,
                        'text' => $data,
                        'target_lang' => locale_get_primary_language($targetLanguage),
                        'glossary_id' => $this->glossaryId,
                        'tag_handling' => 'html'
                    ]
                ]
            );

            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);
        } catch (\Throwable $exception) {
            throw new TranslationException($exception->getMessage());
        }

        return $data['translations'][0]['text'];
    }

    public function getName(): string
    {
        return 'deepl';
    }
}
