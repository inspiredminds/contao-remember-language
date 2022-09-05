[![](https://img.shields.io/packagist/v/inspiredminds/contao-remember-language.svg)](https://packagist.org/packages/inspiredminds/contao-remember-language)
[![](https://img.shields.io/packagist/dt/inspiredminds/contao-remember-language.svg)](https://packagist.org/packages/inspiredminds/contao-remember-language)

Contao Remember Language
=====================

Contao 4 extension to redirect to a language saved in a cookie when using `contao.prepend_locale: true` and requesting the domain without any language parameter in the URL.

## Configuration

The extension allows you to configure the following:

* Enable or disable the redirect.
* Enable or disable saving the current language in a cookie.
* The name of the cookie.

```yml
# Default configuration for extension with alias: "contao_remember_language"
contao_remember_language:

    # Enables the automatic redirect to the saved language.
    enable_redirect:      true

    # Saves the current language as a cookie.
    save_language:        true

    # Name of the cookie where the language is saved.
    cookie_name:          contao_remember_language
```

## Caching

If you use caching, make sure to _not_ add the configured cookie to your `COOKIE_WHITELIST`. The information of the cookie is only relevant for requests to `https://example.org/` (without any path/parameter), and since Contao (at least up to Contao `4.9`) always redirects such requests (with a status code other than `301`) when using `contao.prepend_locale: true`, such requests are never cached. Thus, it is not necessary to prevent caching when the request contains the cookie.
