<?php

namespace Flagrow\AffiliationLinks;

use Flarum\Foundation\Application;
use Illuminate\Contracts\Events\Dispatcher;

return function (Dispatcher $events, Application $app) {
    $events->subscribe(Listeners\AddApiRoutes::class);
    $events->subscribe(Listeners\Assets::class);
    $events->subscribe(Listeners\ReplacePostLinks::class);

    $app->register(Providers\UrlReplacerProvider::class);
};
