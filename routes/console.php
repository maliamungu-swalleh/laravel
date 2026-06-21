<?php

use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

// ─── SCHEDULED COMMANDS ──────────────────────────

// Financial
Schedule::command('ugcfyp:process-withdrawals')->everyThirtyMinutes();
Schedule::command('ugcfyp:release-escrow')->everyFifteenMinutes();

// Reputation
Schedule::command('ugcfyp:calculate-pps')->dailyAt('00:30');
Schedule::command('ugcfyp:reverify-social')->weekly()->sundays()->at('03:00');

// Campaigns
Schedule::command('ugcfyp:close-expired-campaigns')->dailyAt('01:00');

// Security
Schedule::command('ugcfyp:scan-fraud')->everySixHours();

// Maintenance
Schedule::command('backup:run --only-db')->dailyAt('02:00');
Schedule::command('horizon:snapshot')->dailyAt('23:00');