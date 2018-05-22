<?php

namespace Flagrow\AffiliationLinks\Listeners;

use Flagrow\AffiliationLinks\Controllers;
use Flarum\Event\ConfigureApiRoutes;
use Illuminate\Contracts\Events\Dispatcher;

class AddApiRoutes
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(ConfigureApiRoutes::class, [$this, 'routes']);
    }

    public function routes(ConfigureApiRoutes $routes)
    {
        $routes->post(
            '/flagrow/affiliation-links/rules/order',
            'flagrow.affiliation-links.api.rules.order',
            Controllers\RuleOrderController::class
        );
        $routes->get(
            '/flagrow/affiliation-links/rules',
            'flagrow.affiliation-links.api.rules.index',
            Controllers\RuleIndexController::class
        );
        $routes->post(
            '/flagrow/affiliation-links/rules',
            'flagrow.affiliation-links.api.rules.store',
            Controllers\RuleStoreController::class
        );
        $routes->patch(
            '/flagrow/affiliation-links/rules/{id:[0-9]+}',
            'flagrow.affiliation-links.api.rules.update',
            Controllers\RuleUpdateController::class
        );
        $routes->delete(
            '/flagrow/affiliation-links/rules/{id:[0-9]+}',
            'flagrow.affiliation-links.api.rules.delete',
            Controllers\RuleDeleteController::class
        );
    }
}
