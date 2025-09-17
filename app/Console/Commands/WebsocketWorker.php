<?php

namespace App\Console\Commands;

use App\Events\WebSocketMessageReceived;
use Illuminate\Console\Command;
use Ratchet\Client\Connector;
use React\EventLoop\Loop;
use React\EventLoop\LoopInterface;

class WebsocketWorker extends Command
{
    protected $signature = 'app:websocket-worker';

    protected $description = 'Starts the websocket worker process';

    protected $url = 'ws://localhost:8081';

    public function handle()
    {
        $this->info('Starting websocket worker...');

        $loop = Loop::get();
        $connector = new Connector($loop);

        $this->connect($connector, $loop);

        $loop->run();
    }

    protected function connect(Connector $connector, LoopInterface $loop)
    {
        $this->info("Attempting to connect to {$this->url}...");

        $connector($this->url)
            ->then(function ($conn) use ($loop, $connector) {
                $this->info('Connected to WebSocket server');

                $conn->on('message', function ($msg) {
                    $this->info("Received message: {$msg}");
                    event(new WebSocketMessageReceived((string) $msg));
                });

                $conn->on('close', function ($code = null, $reason = null) use ($loop, $connector) {
                    $this->warn("Connection closed (code: {$code}, reason: {$reason}).");
                    $this->retryConnection($connector, $loop);
                });
            }, function ($e) use ($loop, $connector) {
                $this->warn("Could not connect: {$e->getMessage()}.");
                $this->retryConnection($connector, $loop);

                $this->error("Could not connect: {$e->getMessage()}");
            });
    }

    protected function retryConnection(Connector $connector, LoopInterface $loop)
    {
        $this->info('Retrying connection in 5 seconds...');
        $loop->addTimer(5, function () use ($connector, $loop) {
            $this->connect($connector, $loop);
        });
    }
}
