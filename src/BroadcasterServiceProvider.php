<?php
declare(strict_types=1);

namespace IntelliHR\Broadcasting;

use Aws\Kinesis\KinesisClient;
use Illuminate\Broadcasting\BroadcastManager;
use Illuminate\Support\ServiceProvider;
use IntelliHR\Broadcasting\Broadcasters\KinesisBroadcaster;

class BroadcasterServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this
            ->app
            ->make(BroadcastManager::class)
            ->extend(
                'kinesis',
                function ($app, $config) {
                    $parameters = [
                        'version' => 'latest',
                        'region' => $config['region'],
                    ];

                    if ($this->hasKeyAndSecret($config)) {
                        $parameters['credentials'] = [
                            'key' => $config['key'],
                            'secret' => $config['secret'],
                        ];
                    }

                    $client = new KinesisClient($parameters);

                    return new KinesisBroadcaster($client);
                }
            );
    }

    public function register()
    {
    }

    private function hasKeyAndSecret(array $config)
    {
        return array_key_exists('key', $config) && array_key_exists('secret', $config);
    }
}
