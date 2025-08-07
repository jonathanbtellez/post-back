<?php

namespace App\UseCases;

use Illuminate\Support\Facades\Queue;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class GetCommentsUseCase
{
    public function __construct()
    {
    }

    public function execute($data)
    {
        $connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST'),
            env('RABBITMQ_PORT'),
            env('RABBITMQ_USER'),
            env('RABBITMQ_PASSWORD')
        );
        $channel = $connection->channel();

        $exchange   = env('RABBITMQ_EXCHANGE_NAME');
        $routingKey = env('RABBITMQ_ROUTING_KEY');
        $type       = env('RABBITMQ_EXCHANGE_TYPE');
        $queue      = env('RABBITMQ_QUEUE');

        $channel->exchange_declare($exchange, $type, false, true, false);

        $channel->queue_declare($queue, false, true, false, false);

        // Enlazar la cola con el exchange y una routing_key
        $channel->queue_bind($queue, $exchange, $routingKey);

        $msg = new AMQPMessage(json_encode($data), [
            'content_type' => 'application/json',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
        ]);

        $channel->basic_publish($msg, $exchange, $routingKey);

        $channel->close();
        $connection->close();

    }
}