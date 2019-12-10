# GoogleTranslate Bundle
##### GoogleTranslateBundle for Pimcore

Copy data from the source language and translate it by using Google Translate integration.

Supports input and wysiwyg.


#### Instalation
`composer require divanteltd/pimcore-google-translate`

Register bundle in `AppKernel.php` file:

```new GoogleTranslateBundle\GoogleTranslateBundle()```

#### Configuration
```
divante_google_translate:
    api_key: 
    source_lang:
```

#### How it works?

- Copy
![Screenshot](copy.png)

- Translation
![Screenshot](translate.png)

## <a name="authors"></a>About the Author

This module has been created by Divante eCommerce Software House.

![Divante-logo](http://divante.co/logo-HG.png "Divante")

Divante is an expert in providing top-notch eCommerce solutions and products for both B2B and B2C segments. Our core competencies are built around Magento, Pimcore and bespoke software projects (we love Symfony3, Node.js, Angular, React, Vue.js). We specialize in sophisticated integration projects trying to connect hardcore IT with good product design and UX.

We work with industry leaders, like T-Mobile, Continental, and 3M, who perceive technology as their key component to success. In Divante we trust in cooperation, that's why we contribute to open source products and create our own products like [Open Loyalty](http://www.openloyalty.io/ "Open Loyalty") and [VueStorefront](https://github.com/DivanteLtd/vue-storefront "Vue Storefront").

Divante is part of the OEX Group which is listed on the Warsaw Stock Exchange. Our annual revenue has been growing at a minimum of about 30% year on year.

For more information, please visit [Divante.co](https://divante.co/ "Divante.co").