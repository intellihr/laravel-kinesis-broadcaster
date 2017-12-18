# Laravel Kinesis Broadcaster

### Usage

In `config/broadcasting.php` set the default driver to `kinesis` and add
configuration options:

```php
'default' => env('BROADCAST_DRIVER', 'kinesis'),
'connections' => [
    // ...
    'kinesis' => [
        'driver' => 'kinesis',
        'key' => env('AWS_KEY'), // optional
        'secret' => env('AWS_SECRET'), // optional
        'region' => env('KINESIS_REGION')
    ],
],
```

In `config/app.php`, add the Kinesis Service Provider:

```php
'providers' => [
    // ...
    IntelliHR\Broadcasting\BroadcasterServiceProvider::class,
    // ...
],
```

Follow the event broadcasting instructions in the Laravel documentation. Your
channel will be the name of a Kinesis stream that you have already created in
the AWS console.
