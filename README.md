# Fixed Time Window Rate Limiter for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/beyondcode/laravel-fixed-window-limiter.svg?style=flat-square)](https://packagist.org/packages/beyondcode/laravel-fixed-window-limiter)
[![Build Status](https://img.shields.io/travis/beyondcode/laravel-fixed-window-limiter/master.svg?style=flat-square)](https://travis-ci.org/beyondcode/laravel-fixed-window-limiter)
[![Quality Score](https://img.shields.io/scrutinizer/g/beyondcode/laravel-fixed-window-limiter.svg?style=flat-square)](https://scrutinizer-ci.com/g/beyondcode/laravel-fixed-window-limiter)
[![Total Downloads](https://img.shields.io/packagist/dt/beyondcode/laravel-fixed-window-limiter.svg?style=flat-square)](https://packagist.org/packages/beyondcode/laravel-fixed-window-limiter)

This package allows you to easily create and validate rate limiting using the fixed window algorithm.

Fixed window

## Installation

You can install the package via composer:

```bash
composer require beyondcode/laravel-fixed-window-limiter
```

## Usage

``` php
$skeleton = new BeyondCode\FixedWindowLimiter();
echo $skeleton->echoPhrase('Hello, BeyondCode!');
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email marcel@beyondco.de instead of using the issue tracker.

## Credits

- [Marcel Pociot](https://github.com/mpociot)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
