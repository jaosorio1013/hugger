<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class TruncateDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function handle(): void
    {
        Cache::rememberForever('truncating-data', fn() => true);

        Artisan::call('migrate:fresh');
        Artisan::call('db:seed', ['class' => 'WorldSeeder']);
        Artisan::call('db:seed', ['class' => 'UsersSeeder']);
        Artisan::call('db:seed', ['class' => 'ProductsSeeder']);

        Cache::forget('truncating-data');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
    }
}
