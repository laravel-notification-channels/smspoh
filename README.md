# Smspoh Notifications Channel for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/smspoh.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/smspoh)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/smspoh.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/smspoh)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/laravel-notification-channels/smspoh/run-tests.yml?style=flat-square)](https://github.com/laravel-notification-channels/smspoh/actions/workflows/run-tests.yml)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

This package makes it easy to send notifications using [SmsPoh](https://smspoh.com/) with Laravel and 9.x and 10.x.

## Contents

- [Installation](#installation)
	- [Setting up the smspoh](#setting-up-the-smspoh-service)
- [Usage](#usage)
	- [Available Message methods](#available-message-methods)
	- [ On-Demand Notifications](#on-demand-notifications)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

You can install this package via composer:
``` bash
composer require laravel-notification-channels/smspoh
```

### Setting up the Smspoh service

Add your Smspoh token, default sender name (or phone number) to your config/services.php:

```php
// config/services.php
...
'smspoh' => [
    'endpoint' => env('SMSPOH_ENDPOINT', 'https://smspoh.com/api/v2/send'),
    'token' => env('SMSPOH_TOKEN', 'YOUR SMSPOH TOKEN HERE'),
    'sender' => env('SMSPOH_SENDER', 'YOUR SMSPOH SENDER HERE')
],
...
```

## Usage

You can use the channel in your via() method inside the notification:

```php
use Illuminate\Notifications\Notification;
use NotificationChannels\Smspoh\SmspohMessage;

class AccountApproved extends Notification
{
    public function via($notifiable)
    {
        return ["smspoh"];
    }

    public function toSmspoh($notifiable)
    {
        return (new SmspohMessage)->content("Your account was approved!");       
    }
}
```

In your notifiable model, make sure to include a routeNotificationForSmspoh() method, which returns a phone number or an array of phone numbers.

```php
public function routeNotificationForSmspoh()
{
    return $this->phone;
}
```
### On-Demand Notifications
Sometimes you may need to send a notification to someone who is not stored as a "user" of your application. Using the Notification::route method, you may specify ad-hoc notification routing information before sending the notification:

```php
Notification::route('smspoh', '5555555555')                      
            ->notify(new InvoicePaid($invoice));
```
### Available Message methods

`sender()`: Sets the sender's name. *Make sure to register the sender name at you SmsPoh dashboard.*

`content()`: Set a content of the notification message. This parameter should be no longer than 918 char(6 message parts),

`test()`: Send a test message to specific mobile number or not. This parameter should be boolean and default value is `true`.

## Testing

``` bash
$ composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/laravel-notification-channels/smspoh/blob/master/.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Tint Naing Win](https://github.com/tintnaingwin)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
