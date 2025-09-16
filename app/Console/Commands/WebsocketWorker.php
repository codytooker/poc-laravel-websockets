<?php

namespace App\Console\Commands;

use App\Events\WebSocketMessageReceived;
use Illuminate\Console\Command;
use Ratchet\Client\Connector;
use React\EventLoop\Loop;

class WebsocketWorker extends Command
{
    protected $signature = 'app:websocket-worker';

    protected $description = 'Starts the websocket worker process';

    public function handle()
    {
        $this->info('Starting websocket worker...');

        $loop = Loop::get();

        $connector = new Connector($loop);
        $url = 'ws://localhost:8081';

        $connector($url)
            ->then(function ($conn) {
                $this->info('Connected to WebSocket server');

                $conn->on('message', function ($msg) {
                    $this->info("Received message: {$msg}");

                    event(new WebSocketMessageReceived((string) $msg));
                });

                $conn->send('Hello from Laravel Websocket Worker!');
                $conn->send('Another message from laravel');
            }, function ($e) {
                $this->error("Could not connect: {$e->getMessage()}");
            });

        $loop->run();
    }
}
