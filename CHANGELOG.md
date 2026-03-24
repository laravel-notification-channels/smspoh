# Changelog

All notable changes to `smspoh` will be documented in this file

## v2.0.0 - 2026-03-24

### 🚀 SMSPoh Notifications Channel v2.0.0

#### 🌟 New Features

* **SMSPoh API v3 Integration**:
    
    * **Message Scheduling**: Schedule messages to be sent later with `scheduledAt('Y-m-d H:i:s')`.
    * **Encrypted Messages**: Secure banking, OTP, or sensitive alerts with `encrypt()` and optional `encryptKey($key)`.
    * **Unicode Support**: Support for Unicode messages via `unicode()`.
    * **Custom Delivery Receipts**: Define standard webhooks at runtime using `deliveryReceiptUrl($url)`.
    * **Client Reference**: Append tracking references with `clientReference($id)`.
    
* **Laravel Support**: Compatibility with **Laravel 13.x**.
    


---

#### ⚠️ Breaking Changes & Upgrading

Please review the full [UPGRADE.md](https://github.com/laravel-notification-channels/smspoh/blob/master/UPGRADE.md) if coming from v1.

##### 1. Configuration updates (`config/services.php`)

The v3 API uses modern key/secret credentials. Change your `token` key to `key` & `secret`. Additionally, `sender` is renamed to `from`.

###### Previous (v1):

```php
'smspoh' => [
    'token' => env('SMSPOH_TOKEN'),
    'sender' => env('SMSPOH_FROM'),
]

```
###### New (v2):

```php
'smspoh' => [
    'key' => env('SMSPOH_KEY'),
    'secret' => env('SMSPOH_SECRET'),
    'from' => env('SMSPOH_FROM'),
]

```
##### 2. Method Deprecation

`SmspohMessage->sender()` is deprecated. Use `SmspohMessage->from()` instead.

**Full Changelog**: https://github.com/laravel-notification-channels/smspoh/compare/v1.6.0...v2.0.0

## v1.6.0 - 2025-03-16

### What's Changed

* chore(deps): bump nick-fields/retry from 2 to 3 by @dependabot in https://github.com/laravel-notification-channels/smspoh/pull/8
* Support Laravel 12 by @tintnaingwin in https://github.com/laravel-notification-channels/smspoh/pull/9

**Full Changelog**: https://github.com/laravel-notification-channels/smspoh/compare/v1.5.0...v1.6.0

## v1.5.0 - 2024-04-07

### Added

- Support Laravel 11.x

## 1.4.0 - 2023-02-15

### Added

- Support Laravel 10.x
- Test with Pest.
- Add PHPStan for static analysis using GitHub Action.
- Add Pint using GitHub Action.
- Add Changelog updater workflow.

### Changed

- Drop support for Laravel < 9.
- Drop support for PHP < 8.1.
- Improve Test.

## 1.3.0 - 2022-02-05

## What's Changed

- Laravel 9 support

## 1.2.0 - 2021-12-05

## What's Changed

- Add PHP 8 support
- Drop Laravel 5.*

## 1.1.0 - 2020-09-26

- Laravel 8 support

## 1.0.1 - 2020-02-05

- Laravel 7 support

## 1.0.0 - 2019-12-25

- initial release
