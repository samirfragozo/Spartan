<?php

namespace App\Console\Commands;

use App\Punch;
use ErrorException;
use Exception;
use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ListenRabbit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:rabbit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Catches Data from RabbitMQ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @throws ErrorException
     */
    public function handle()
    {
        $connection = new AMQPStreamConnection(env('RABBIT_HOST', 'localhost'), env('RABBIT_PORT', 5672), env('RABBIT_USERNAME', ''), env('RABBIT_PASSWORD', ''));
        $channel = $connection->channel();

        $channel->queue_declare(env('RABBIT_QUEUE_SERVER', 'server'), false, true, false, false);

        echo " [*] Waiting for messages. To exit press CTRL+C\n";

        $callback = function ($msg) {
            try{
                $request = json_decode($msg->body);

                $punch = new Punch;

                $punch->date = $request->date;
                $punch->client_id = $request->id;
                $punch->access_id = $request->sucursal;

                $punch->save();

                echo " [-] Received: {$msg->body}\n";
            }
            catch(Exception $e){
                echo " [x] Error: {$e->getMessage()}\n";
            }
        };

        $channel->basic_consume(env('RABBIT_QUEUE_SERVER', 'server'), '', false, true, false, false, $callback);

        while (count($channel->callbacks)) {
            $channel->wait();
        }
    }
}
