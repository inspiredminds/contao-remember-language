[![](https://img.shields.io/maintenance/yes/2018.svg)](https://github.com/inspiredminds/contao-remember-language)
[![](https://img.shields.io/packagist/v/inspiredminds/contao-remember-language.svg)](https://packagist.org/packages/inspiredminds/contao-remember-language)
[![](https://img.shields.io/packagist/dt/inspiredminds/contao-remember-language.svg)](https://packagist.org/packages/inspiredminds/contao-remember-language)

Contao Remember Language
=====================

Contao 4 bundle to redirect to a language saved in a cookie.

## Installation

Require the bundle via composer:
```
composer require inspiredminds/contao-remember-language
```
If you use the Contao Standard Edition, you will have to add
```php
new InspiredMinds\ContaoRememberLanguage\ContaoRememberLanguageBundle()
```
to your `AppKernel.php`.

## Usage

After installation you will see two new system settings:

* __Use language cookie__
  This will enable the automatic redirect according to the stored language cookie.

* __Save language cookie__
  This will enable the automatic generation of the language cookie on each 
  request that contains the language parameter.

The cookie's name is `forceLanguage` in case you do not want to use the second 
option and rather generate the cookie yourself (e.g. if you want to provide a 
language selection pop-up).
