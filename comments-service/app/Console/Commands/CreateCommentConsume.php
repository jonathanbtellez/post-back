<?php

namespace App\Console\Commands;

use App\UseCases\CreateCommentUseCase;
use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class CreateCommentConsume extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:first_comment_queue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST'),
            env('RABBITMQ_PORT'),
            env('RABBITMQ_USER'),
            env('RABBITMQ_PASSWORD')
        );
        $channel = $connection->channel();

        $queue = env('RABBITMQ_QUEUE');
        $exchange = env('RABBITMQ_EXCHANGE_NAME');
        $type = env('RABBITMQ_EXCHANGE_TYPE');
        $routingKey = env('RABBITMQ_ROUTING_KEY');

        $channel->exchange_declare($exchange, $type, false, true, false);
        $channel->queue_declare($queue, false, true, false, false);
        $channel->queue_bind($queue, $exchange, $routingKey);

        $callback = function (AMQPMessage $msg) {
            $this->info('Mensaje recibido: ' . $msg->getBody());
            (new CreateCommentUseCase())->execute([
                'content' => 'Testing comment by rabbit mq',
                'post_id' => json_decode($msg->getBody())->post_id, 
            ]);
        };

        $channel->basic_consume($queue, '', false, true, false, false, $callback);

        $this->info("Esperando mensajes en '$queue'...");

        while ($channel->is_consuming()) {
            $channel->wait();
        }

    }
}

