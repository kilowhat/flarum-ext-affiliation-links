<?php

namespace Kilowhat\AffiliationLinks\Providers;

use Flarum\Foundation\AbstractServiceProvider;
use Kilowhat\AffiliationLinks\Repositories\RuleRepository;
use Kilowhat\AffiliationLinks\UrlReplacer;

class UrlReplacerProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->app->singleton(UrlReplacer::class, function () {
            /**
             * @var $rules RuleRepository
             */
            $rules = $this->app->make(RuleRepository::class);

            $replacer = new UrlReplacer();

            foreach ($rules->all() as $rule) {
                $replacer->addRule($rule);
            }

            return $replacer;
        });
    }
}
