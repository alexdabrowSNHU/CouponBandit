<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RdKafka\Conf;
use RdKafka\KafkaConsumer;
use RdKafka\Message;
use Symfony\Component\HttpFoundation\EventStreamResponse;
use Symfony\Component\HttpFoundation\ServerEvent;

class KafkaStreamController extends Controller
{
    public function __invoke(Request $request): EventStreamResponse
    {
        $heartbeatIntervalSeconds = 5;
        $brokers = (string) config('kafka.brokers');
        $userId = (string) (Auth::id() ?? 'guest');
        $connectionId = (string) ($request->query('connection') ?: bin2hex(random_bytes(8)));

        return new EventStreamResponse(function () use ($heartbeatIntervalSeconds, $brokers, $userId, $connectionId) {
            $consumer = $this->makeConsumer($brokers, $userId, $connectionId);
            $lastHeartbeatAt = 0.0;

            try {
                $consumer->subscribe(['search_events', 'page_navigation_events']);

                while (! connection_aborted()) {
                    $message = $consumer->consume(1000);

                    if ($message === null) {
                        continue;
                    }

                    if ($message->err === RD_KAFKA_RESP_ERR__TIMED_OUT) {
                        if ((microtime(true) - $lastHeartbeatAt) >= $heartbeatIntervalSeconds) {
                            $lastHeartbeatAt = microtime(true);

                            yield new ServerEvent(
                                data: json_encode(['connection' => $connectionId], JSON_THROW_ON_ERROR),
                                type: 'heartbeat'
                            );
                        }

                        continue;
                    }

                    if ($message->err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
                        yield new ServerEvent(
                            data: json_encode([
                                'code' => $message->err,
                                'error' => $message->errstr(),
                            ], JSON_THROW_ON_ERROR),
                            type: 'error'
                        );

                        break;
                    }

                    yield $this->toServerEvent($message);
                }
            } finally {
                $consumer->unsubscribe();
            }
        });
    }

    private function makeConsumer(string $brokers, string $userId, string $connectionId): KafkaConsumer
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', $brokers);
        $conf->set('group.id', sprintf('couponbandit-sse-%s-%s', $userId, $connectionId));
        $conf->set('enable.auto.commit', 'true');
        $conf->set('auto.offset.reset', 'latest');
        $conf->set('socket.keepalive.enable', 'true');
        $conf->set('session.timeout.ms', '30000');
        $conf->set('max.poll.interval.ms', '45000');

        return new KafkaConsumer($conf);
    }

    private function toServerEvent(Message $message): ServerEvent
    {
        $payload = json_decode((string) $message->payload, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $payload = ['raw' => $message->payload];
        }

        $eventName = match ($message->topic_name) {
            'search_events' => 'search_event',
            'page_navigation_events' => 'page_navigation_event',
            default => 'message',
        };

        return new ServerEvent(
            data: json_encode([
                'topic' => $message->topic_name,
                'event' => $eventName,
                'payload' => $payload,
                'kafka_partition' => $message->partition,
                'kafka_offset' => $message->offset,
                'timestamp' => $message->timestamp ?? null,
                'key' => $message->key,
            ], JSON_THROW_ON_ERROR),
            type: $eventName,
            id: sprintf('%s:%d:%d', $message->topic_name, $message->partition, $message->offset)
        );
    }
}
