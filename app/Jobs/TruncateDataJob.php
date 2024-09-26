<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class TruncateDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function handle(): void
    {
        Cache::rememberForever('truncating-data', fn() => true);

        DB::table('client_actions')->truncate();
        DB::table('activity_log')->truncate();
        DB::table('client_tag')->truncate();
        DB::table('client_contact_tag')->truncate();
        DB::table('tags')->truncate();
        DB::table('client_contacts')->truncate();
        DB::table('deal_details')->truncate();
        DB::table('deals')->truncate();
        DB::table('clients')->truncate();

        Cache::forget('truncating-data');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
    }
}
