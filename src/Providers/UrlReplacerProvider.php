<?php

namespace Flagrow\AffiliationLinks\Providers;

use Flagrow\AffiliationLinks\Repositories\RuleRepository;
use Flagrow\AffiliationLinks\UrlReplacer;
use Flarum\Foundation\AbstractServiceProvider;

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
