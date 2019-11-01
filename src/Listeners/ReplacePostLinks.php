<?php

namespace Kilowhat\AffiliationLinks\Listeners;

use Flarum\Formatter\Event\Rendering;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Arr;
use Kilowhat\AffiliationLinks\UrlReplacer;
use s9e\TextFormatter\Utils;

class ReplacePostLinks
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(Rendering::class, [$this, 'configure']);
    }

    public function configure(Rendering $event)
    {
        $event->xml = Utils::replaceAttributes($event->xml, 'URL', function ($attributes) {
            if (Arr::has($attributes, 'url')) {
                /**
                 * @var $replacer UrlReplacer
                 */
                $replacer = app(UrlReplacer::class);

                $uri = $replacer->replace(Arr::get($attributes, 'url'));

                if ($uri) {
                    $attributes['url'] = $uri;
                }
            }

            return $attributes;
        });
    }
}
