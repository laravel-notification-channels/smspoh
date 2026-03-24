# Upgrade Guide

## Upgrading from v1 to v2

This guide covers the breaking changes and updates required when upgrading to support SMSPoh API v3.

### Configuration (`config/services.php`)

The configuration structure has been updated to align with the API v3 authentication standards (`key` and `secret`) and field naming (`from`).

#### Previous Configuration (v1)
```php
'smspoh' => [
    'endpoint' => env('SMSPOH_ENDPOINT', 'https://smspoh.com/api/v2/send'),
    'token' => env('SMSPOH_TOKEN', 'YOUR SMSPOH TOKEN HERE'),
    'sender' => env('SMSPOH_SENDER', 'YOUR SMSPOH SENDER HERE')
],
```

#### New Configuration (v2)
In v3, you should use `key` and `secret` instead of `token`. The `endpoint` is now defaulting to the v3 REST URL and can usually be omitted. Additionally, `sender` is now `from`.

```php
'smspoh' => [
    'key' => env('SMSPOH_KEY', 'YOUR SMSPOH KEY HERE'),
    'secret' => env('SMSPOH_SECRET', 'YOUR SMSPOH SECRET HERE'),
    'from' => env('SMSPOH_FROM', 'YOUR SMSPOH SENDER HERE') // previously 'sender'
],
```

> [!NOTE]
> Backward compatibility is maintained for `sender` in config and `token` fallback, but upgrading to the new keys is strongly recommended.

---

### Message Methods (`SmspohMessage`)

-   **Deprecated `sender()`**: The `sender()` method has been deprecated. Use `from()` instead.
-   **New `from()`**: Use this to define the Sender ID for the message.
-   **New `clientReference()`**: You can now pass unique client references with `clientReference('your-reference-id')`.

#### Example Updates
```diff
- return (new SmspohMessage)->content('Hello')->sender('Company');
+ return (new SmspohMessage)->content('Hello')->from('Company');
```

---

### API Client (`SmspohApi`)

If you construct `SmspohApi` manually, it now internally expects a generated token standard `base64_encode("$key:$secret")`.
The default Endpoint constant fallback uses `https://v3.smspoh.com/api/rest/send` via `SmspohApi::ENDPOINT`.
