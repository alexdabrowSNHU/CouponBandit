<?php

namespace App\Kafka\Handlers;

use Illuminate\Support\Facades\Log;
use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Contracts\Handler;
use Junges\Kafka\Contracts\MessageConsumer;

class CouponBanditEventHandler implements Handler
{
    public function __invoke(ConsumerMessage $message, MessageConsumer $consumer): void
    {
        $payload = $message->getBody();

        match ($message->getTopicName()) {
            'search_events' => $this->handleSearchEvent($payload, $message),
            'page_navigation_events' => $this->handlePageNavigationEvent($payload, $message),
            default => $this->handleUnexpectedTopic($payload, $message),
        };
    }

    private function handleSearchEvent(mixed $payload, ConsumerMessage $message): void
    {
        Log::info('Kafka search event consumed', [
            'topic' => $message->getTopicName(),
            'partition' => $message->getPartition(),
            'offset' => $message->getOffset(),
            'key' => $message->getKey(),
            'query' => $payload['query'] ?? null,
            'user_id' => $payload['user_id'] ?? null,
            'results' => $payload['results'] ?? null,
            'searched_at' => $payload['searched_at'] ?? null,
            'payload' => $payload,
        ]);
    }

    private function handlePageNavigationEvent(mixed $payload, ConsumerMessage $message): void
    {
        Log::info('Kafka page navigation event consumed', [
            'topic' => $message->getTopicName(),
            'partition' => $message->getPartition(),
            'offset' => $message->getOffset(),
            'key' => $message->getKey(),
            'user_id' => $payload['user_id'] ?? null,
            'prev_url' => $payload['prev_url'] ?? null,
            'new_url' => $payload['new_url'] ?? null,
            'navigated_at' => $payload['navigated_at'] ?? null,
            'payload' => $payload,
        ]);
    }

    private function handleUnexpectedTopic(mixed $payload, ConsumerMessage $message): void
    {
        Log::warning('Kafka message consumed from unexpected topic', [
            'topic' => $message->getTopicName(),
            'partition' => $message->getPartition(),
            'offset' => $message->getOffset(),
            'payload' => $payload,
        ]);
    }
}
