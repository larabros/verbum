# verbum

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what
PSRs you support to avoid any confusion with users and contributors.

## Install

Via Composer

``` bash
$ composer require larabros/verbum
```

## Usage

``` php
$vox = new \Larabros\Verbum\Vox('en_GB', './assets/copy');
echo $vox->get('copy.title');
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email nicolas_gutierrez@scee.net instead of using the issue tracker.

## Credits

- [Nicolas][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/wes/verbum.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/wes/verbum/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/wes/verbum.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/wes/verbum.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/wes/verbum.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/wes/verbum
[link-travis]: https://travis-ci.org/wes/verbum
[link-scrutinizer]: https://scrutinizer-ci.com/g/wes/verbum/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/wes/verbum
[link-downloads]: https://packagist.org/packages/wes/verbum
[link-author]: https://github.com/nicgutierrez
[link-contributors]: ../../contributors
