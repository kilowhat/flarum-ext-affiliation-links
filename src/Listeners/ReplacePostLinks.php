<?php

namespace Flagrow\AffiliationLinks\Listeners;

use Flagrow\AffiliationLinks\UrlReplacer;
use Flarum\Event\ConfigureFormatterRenderer;
use Illuminate\Contracts\Events\Dispatcher;
use s9e\TextFormatter\Utils;

class ReplacePostLinks
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(ConfigureFormatterRenderer::class, [$this, 'configure']);
    }

    public function configure(ConfigureFormatterRenderer $event)
    {
        $event->xml = Utils::replaceAttributes($event->xml, 'URL', function ($attributes) {
            if (array_has($attributes, 'url')) {
                /**
                 * @var $replacer UrlReplacer
                 */
                $replacer = app(UrlReplacer::class);

                $uri = $replacer->replace(array_get($attributes, 'url'));

                if ($uri) {
                    $attributes['url'] = $uri;
                }
            }

            return $attributes;
        });
    }
}
