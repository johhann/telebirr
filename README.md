# Telebirr

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

```bash
composer require johhann/telebirr
```

## Usage

You can publish config files by running:

```
php artisan vendor:publish --provider="Johhann\Telebirr\TelebirrServiceProvider" --tag="telebirr.config"
```

Add the following environment variable to your `.env` file and set their values telebirr provider
```
TELEBIRR_APP_ID=
TELEBIRR_APP_KEY=
TELEBIRR_NOTIFY_URL=
TELEBIRR_RETURN_URL=
TELEBIRR_TRADE_PAY_URL=
TELEBIRR_PUBLIC_KEY=
```

## Testing

```bash
composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email `johannesm1219@gmail.com` instead of using the issue tracker.

## Credits

- [Yohannes Mekonnen](https://github.com/johhann)
## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/johhann/telebirr.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/johhann/telebirr.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/johhann/telebirr/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/johhann/telebirr
[link-downloads]: https://packagist.org/packages/johhann/telebirr
[link-travis]: https://travis-ci.org/johhann/telebirr
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/johhann
[link-contributors]: ../../contributors
