<?php

namespace Kilowhat\AffiliationLinks;

use Flarum\Extend;
use Flarum\Foundation\Application;
use Illuminate\Contracts\Events\Dispatcher;

return [
    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js')
        ->css(__DIR__ . '/resources/less/admin.less'),
    new Extend\Locales(__DIR__ . '/resources/locale'),

    (new Extend\Routes('api'))
        ->post(
            '/kilowhat-affiliation-links/rules/order',
            'kilowhat.affiliation-links.api.rules.order',
            Controllers\RuleOrderController::class
        )
        ->get(
            '/kilowhat-affiliation-links/rules',
            'kilowhat.affiliation-links.api.rules.index',
            Controllers\RuleIndexController::class
        )
        ->post(
            '/kilowhat-affiliation-links/rules',
            'kilowhat.affiliation-links.api.rules.store',
            Controllers\RuleStoreController::class
        )
        ->patch(
            '/kilowhat-affiliation-links/rules/{id:[0-9]+}',
            'kilowhat.affiliation-links.api.rules.update',
            Controllers\RuleUpdateController::class
        )
        ->delete(
            '/kilowhat-affiliation-links/rules/{id:[0-9]+}',
            'kilowhat.affiliation-links.api.rules.delete',
            Controllers\RuleDeleteController::class
        ),

    function (Dispatcher $events, Application $app) {
        $events->subscribe(Listeners\ReplacePostLinks::class);

        $app->register(Providers\UrlReplacerProvider::class);
    },
];
