<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class TrafficLogController extends Controller
{
    public function index()
    {
        $query = <<<SQL
SELECT *
FROM page_navigation_events
ORDER BY navigated_at DESC
LIMIT 50
FORMAT JSON
SQL;

        try {
            $response = Http::withBasicAuth(
                config('services.clickhouse.username'),
                config('services.clickhouse.password')
            )
                ->timeout(5)
                ->withBody($query, 'text/plain')
                ->post(rtrim(config('services.clickhouse.url'), '/'));

            $response->throw();
        } catch (RequestException $exception) {
            report($exception);

            return response()->json([
                'message' => 'Traffic log is currently unavailable.',
            ], 503);
        }

        $payload = $response->json();

        return response()->json([
            'events' => collect($payload['data'] ?? [])
                ->map(fn (array $event) => [
                    'user_id' => $event['user_id'] ?? null,
                    'prev_url' => $event['prev_url'] ?? '',
                    'new_url' => $event['new_url'] ?? '',
                    'navigated_at' => $event['navigated_at'] ?? null,
                ])
                ->values(),
        ]);
    }
}
