<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('about:mali', function () {
    $this->info(config('mali.app_name', 'Mali') . ' application is ready.');
})->purpose('Display Mali application status');
