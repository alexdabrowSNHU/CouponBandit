<?php

namespace Database\Seeders;

use App\Models\DevLog;
use App\Models\User;
use Illuminate\Database\Seeder;

class DevLogSeeder extends Seeder
{
    public function run(): void
    {
        // Create the dev log admin user
        User::updateOrCreate(
            ['email' => 'laravelisfun@couponbandit.dev'],
            [
                'name' => 'laravelisfun',
                'password' => 'sfluvshwr22#3',
            ]
        );

        // Seed the existing dev log entries
        $logs = [
            ['message' => 'Added 419 redirect flow to login page for expired sessions.', 'log_date' => '2026-03-11'],
            ['message' => 'Removed hardcoded password defaults from compose config.', 'log_date' => '2026-03-11'],
            ['message' => 'Added "My Rewards" page.', 'log_date' => '2026-03-11'],
            ['message' => 'Added optimistic rendering for favorite icon via Ajax POST, rollback on failure. Deal cards have been rewritten into a reuseable component.', 'log_date' => '2026-03-12'],
            ['message' => 'Working on the deals page for a specific merchant (/stores/{merchant_id}). Running migration to index the merchant id in the deals table to avoid full table scans.', 'log_date' => '2026-03-13'],
        ];

        foreach ($logs as $log) {
            DevLog::updateOrCreate($log);
        }
    }
}
