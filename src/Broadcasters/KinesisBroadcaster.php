<?php
declare(strict_types=1);

namespace IntelliHR\Broadcasting\Broadcasters;

use Aws\Kinesis\KinesisClient;
use Illuminate\Contracts\Broadcasting\Broadcaster;

class KinesisBroadcaster implements Broadcaster
{
    /**
     * @var KinesisClient
     */
    protected $client;

    public function __construct(KinesisClient $client)
    {
        $this->client = $client;
    }

    public function broadcast(array $channels, $event, array $payload = [])
    {
        $payload = [
            'event' => $event,
            'data' => $payload,
        ];

        foreach ($channels as $channel) {
            $this
                ->client
                ->putRecord([
                    'StreamName' => $channel,
                    'Data' => json_encode($payload),
                    'PartitionKey' => '',
                ]);
        }
    }
}
