<p align="center">
    <a href="https://www.mangoweb.cz/en/" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/38423357?s=200&v=4"/>
    </a>
</p>
<h1 align="center">
SMS Manager Plugin
<br />
    <a href="https://packagist.org/packages/mangoweb-sylius/sylius-smsmanager-plugin" title="License" target="_blank">
        <img src="https://img.shields.io/packagist/l/mangoweb-sylius/sylius-smsmanager-plugin.svg" />
    </a>
    <a href="https://packagist.org/packages/mangoweb-sylius/sylius-smsmanager-plugin" title="Version" target="_blank">
        <img src="https://img.shields.io/packagist/v/mangoweb-sylius/sylius-smsmanager-plugin.svg" />
    </a>
    <a href="http://travis-ci.org/mangoweb-sylius/SyliusSMSManagerPlugin" title="Build status" target="_blank">
        <img src="https://img.shields.io/travis/mangoweb-sylius/SyliusSMSManagerPlugin/master.svg" />
    </a>
</h1>

## Features

* Use https://smsmanager.cz account to send SMS to customers
* Inform your customers with a text message that the package has been sent
* Custom text for every shipping method and language
* Use variables to personalise the text

<p align="center">
	<img src="https://raw.githubusercontent.com/mangoweb-sylius/SyliusSMSManagerPlugin/master/doc/admin.png"/>
</p>

## Installation

1. Run `$ composer require mangoweb-sylius/sylius-smsmanager-plugin`.
2. Register `\MangoSylius\SmsManagerPlugin\MangoSyliusSmsManagerPlugin` in your Kernel.
3. Import `@MangoSyliusSmsManagerPlugin/Resources/config/resources.yml` in the config.yml.
4. Your Entity `Channel` has to implement `\MangoSylius\SmsManagerPlugin\Model\SmsManagerChannelInterface`. You can use Trait `MangoSylius\SmsManagerPlugin\Model\SmsManagerChannelTrait`.
5. Your Entity `ShippingMethodTranslation` has to implement `\MangoSylius\SmsManagerPlugin\Model\SmsManagerShippingMethodInterface`. You can use Trait `MangoSylius\SmsManagerPlugin\Model\SmsManagerShippingMethodTrait`.
6. Include template `@MangoSyliusSmsManagerPlugin/channelSmsSegmentForm.html.twig` in `@SyliusAdmin/Channel/_form.html.twig`.
6. Include template `@MangoSyliusSmsManagerPlugin/shippingMethodSmsForm.html.twig` in `@SyliusAdmin/ShippingMethod/_form.html.twig`.
For guide to use your own entity see [Sylius docs - Customizing Models](https://docs.sylius.com/en/1.3/customization/model.html)

### Usage

First enter SMS Manager credentials and other parameters in channel settings, then enter SMS text for each shipping method. If the text is blank, no SMS will be sent.

You can use the following variables in the text:

```
{{ orderNumber }}
{{ trackingNumber }}
{{ address.fullName }}
{{ address.company }}
{{ address.street }}
{{ address.postCode }}
{{ address.city }}
{{ address.provinceCode }}
{{ address.provinceName }}
{{ address.countryCode }}
```

<p align="center">
	<img src="https://raw.githubusercontent.com/mangoweb-sylius/SyliusSMSManagerPlugin/master/doc/smstext.png"/>
</p>

## Development

### Usage

- Create symlink from .env.dist to .env or create your own .env file
- Develop your plugin in `/src`
- See `bin/` for useful commands

### Testing

After your changes you must ensure that the tests are still passing.
* Easy Coding Standard
  ```bash
  bin/ecs.sh
  ```
* PHPStan
  ```bash
  bin/phpstan.sh
  ```
License
-------
This library is under the MIT license.

Credits
-------
Developed by [manGoweb](https://www.mangoweb.eu/).
