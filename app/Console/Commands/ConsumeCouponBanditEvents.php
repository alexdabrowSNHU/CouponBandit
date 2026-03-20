<?php

namespace App\Console\Commands;

use App\Kafka\Handlers\CouponBanditEventHandler;
use Illuminate\Console\Command;
use Junges\Kafka\Facades\Kafka;

class ConsumeCouponBanditEvents extends Command
{
    protected $signature = 'couponbandit:kafka-consume
        {--group-id= : Override the Kafka consumer group id}
        {--max-messages= : Stop after consuming a fixed number of messages}
        {--max-time= : Stop after consuming for a fixed number of seconds}';

    protected $description = 'Consume CouponBandit Kafka events from search and page navigation topics';

    public function handle(CouponBanditEventHandler $handler): int
    {
        $consumer = Kafka::consumer(
            ['search_events', 'page_navigation_events'],
            $this->option('group-id') ?: config('kafka.consumer_group_id')
        )->withHandler($handler);

        $maxMessages = $this->option('max-messages');
        if (is_numeric($maxMessages)) {
            $consumer->withMaxMessages((int) $maxMessages);
        }

        $maxTime = $this->option('max-time');
        if (is_numeric($maxTime)) {
            $consumer->withMaxTime((int) $maxTime);
        }

        $this->components->info('Consuming Kafka topics: search_events, page_navigation_events');

        $consumer->build()->consume();

        return self::SUCCESS;
    }
}
