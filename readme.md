# Google Translate
[![Analysis Actions](https://github.com/DivanteLtd/pimcore-google-translate/workflows/Analysis/badge.svg?branch=master)](https://github.com/DivanteLtd/pimcore-google-translate/actions)
[![Tests Actions](https://github.com/DivanteLtd/pimcore-google-translate/workflows/Tests/badge.svg?branch=master)](https://github.com/DivanteLtd/pimcore-google-translate/actions)
[![Latest Stable Version](https://poser.pugx.org/divante-ltd/pimcore-google-translate/v/stable)](https://packagist.org/packages/divante-ltd/pimcore-google-translate)
[![Total Downloads](https://poser.pugx.org/divante-ltd/pimcore-google-translate/downloads)](https://packagist.org/packages/divante-ltd/pimcore-google-translate)
[![License](https://poser.pugx.org/divante-ltd/pimcore-google-translate/license)](https://github.com/DivanteLtd/divante-ltd/pimcore-google-translate/blob/master/LICENSE)

Copy data from the source language and translate it by using Google Translate integration.
Supports input and wysiwyg.

**Table of Contents**
- [Google Translate](#google-translate)
	- [Compatibility](#compatibility)
	- [Installing/Getting started](#installinggetting-started)
	- [Requirements](#requirements)
	- [Configuration](#configuration)
	- [How it works?](#how-it-works)
	- [Testing](#testing)
	- [Contributing](#contributing)
	- [Licence](#licence)
	- [Standards & Code Quality](#standards--code-quality)
	- [About Authors](#about-authors)

## Compatibility

This module is compatible with Pimcore 5.5.0 and higher.

## Installing/Getting started

```bash
composer require divante-ltd/pimcore-google-translate
```

Enable the Bundle:
```bash
./bin/console pimcore:bundle:enable GoogleTranslateBundle
```

## Configuration

```
divante_google_translate:
    api_key: 
    source_lang:
```

#### How it works?

- Copy
![Screenshot](docs/copy.png)

- Translation
![Screenshot](docs/translate.png)

## Testing
Unit Tests:
```bash
PIMCORE_TEST_DB_DSN="mysql://username:password@localhost/pimcore_test" \
    vendor/bin/phpunit
```

Functional Tests:
```bash
PIMCORE_TEST_DB_DSN="mysql://username:password@localhost/pimcore_test" \
    vendor/bin/codecept run -c tests/codeception.dist.yml
```

## Contributing
If you'd like to contribute, please fork the repository and use a feature branch. Pull requests are warmly welcome.

## Licence 
CoreShop VsBridge source code is completely free and released under the 
[GNU General Public License v3.0](https://github.com/DivanteLtd/divante-ltd/pimcore-google-translate/blob/master/LICENSE).

## Standards & Code Quality
This module respects all Pimcore 5 code quality rules and our own PHPCS and PHPMD rulesets.

## About Authors
![Divante-logo](http://divante.co/logo-HG.png "Divante")

We are a Software House from Europe, existing from 2008 and employing about 150 people. Our core competencies are built 
around Magento, Pimcore and bespoke software projects (we love Symfony3, Node.js, Angular, React, Vue.js). 
We specialize in sophisticated integration projects trying to connect hardcore IT with good product design and UX.

We work for Clients like INTERSPORT, ING, Odlo, Onderdelenwinkel and CDP, the company that produced The Witcher game. 
We develop two projects: [Open Loyalty](http://www.openloyalty.io/ "Open Loyalty") - an open source loyalty program 
and [Vue.js Storefront](https://github.com/DivanteLtd/vue-storefront "Vue.js Storefront").

We are part of the OEX Group which is listed on the Warsaw Stock Exchange. Our annual revenue has been growing at a 
minimum of about 30% year on year.

Visit our website [Divante.co](https://divante.co/ "Divante.co") for more information.
