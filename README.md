# Fork CMS PHP API class
[![Latest Stable Version](http://img.shields.io/packagist/v/forkcms/api-wrapper-class.svg)](https://packagist.org/packages/forkcms/api-wrapper-class)
[![License](http://img.shields.io/badge/license-MIT-lightgrey.svg)](https://github.com/forkcms/api-wrapper-class/blob/master/LICENSE)
[![Build Status](http://img.shields.io/travis/forkcms/api-wrapper-class.svg)](https://travis-ci.org/forkcms/api-wrapper-class)

This Fork CMS PHP class can communicate with the API from a Fork CMS website.

## Usage

### Installation

``` json
{
    "require": {
        "forkcms/api-wrapper-class": "1.0.*"
    }
}
```
> Adding this code in your `composer.json` file will get the [latest fork-cms-php-api Packagist package](https://packagist.org/packages/forkcms/api-wrapper-class) using [Composer](https://getcomposer.org).

### Example

``` php
use ForkCms\Api\ForkCms;
```

**Function calls which do not require authentication**

```php
$api = new ForkCms(
    $url,
    $email
);

$response = $api->coreGetAPIKey($email, $password);

$apiKey = $response['api_key'];

```

**Function calls which require authentication**
```php
$api = new ForkCms(
    $url,
    $email,
    $apiKey
);

$response = $api->coreAppleAddDevice(APPLE_DEVICE_TOKEN);
$response = $api->coreAppleRemoveDevice(APPLE_DEVICE_TOKEN);
$response = $api->blogCommentsGet();
// ...
```
> [View all examples](/examples/example.php) or check [the Fork CMS API Wrapper Class](/src/).

### Tests

``` bash
phpunit
```

## Documentation

The class is well documented inline. If you use a decent IDE you'll see that each method is documented with PHPDoc.


## Contributing

Contributions are **welcome** and will be fully **credited**.

### Pull Requests

> To add or update code

- **Coding Syntax** - Please keep the code syntax consistent with the rest of the package.
- **Add unit tests!** - Your patch won't be accepted if it doesn't have tests.
- **Document any change in behavior** - Make sure the README and any other relevant documentation are kept up-to-date.
- **Consider our release cycle** - We try to follow [semver](http://semver.org/). Randomly breaking public APIs is not an option.
- **Create topic branches** - Don't ask us to pull from your master branch.
- **One pull request per feature** - If you want to do more than one thing, send multiple pull requests.
- **Send coherent history** - Make sure each individual commit in your pull request is meaningful. If you had to make multiple intermediate commits while developing, please squash them before submitting.

### Issues

> For bug reporting or code discussions.

More info on how to work with GitHub on help.github.com.

## Credits

- [Tijs Verkoyen](https://github.com/tijsverkoyen)
- [Jeroen Desloovere](https://github.com/jeroendesloovere)
- [All Contributors](https://github.com/forkcms/api-wrapper-class/contributors)

## License

The module is licensed under [MIT](./LICENSE.md). In short, this license allows you to do everything as long as the copyright statement stays present.