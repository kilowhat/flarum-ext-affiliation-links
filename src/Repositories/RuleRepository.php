<?php

namespace Kilowhat\AffiliationLinks\Repositories;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Database\Eloquent\Collection;
use Kilowhat\AffiliationLinks\Rule;
use Kilowhat\AffiliationLinks\Validators\RuleValidator;

class RuleRepository
{
    protected $rule;
    protected $validator;
    protected $cache;

    protected $rememberState;

    const CACHE_KEY = 'kilowhat-affiliation-links-rules';

    public function __construct(Rule $rule, RuleValidator $validator, Repository $cache)
    {
        $this->rule = $rule;
        $this->validator = $validator;
        $this->cache = $cache;
    }

    /**
     * @return Rule[]|Collection
     */
    public function all()
    {
        return $this->cache->rememberForever(self::CACHE_KEY, function () {
            return $this->rule->newQuery()->orderBy('sort')->get();
        });
    }

    public function clearCache()
    {
        $this->cache->forget(self::CACHE_KEY);
    }

    /**
     * @param string $id
     * @return Rule
     */
    public function findOrFail($id)
    {
        return $this->rule->newQuery()->findOrFail($id);
    }

    public function store(array $attributes)
    {
        $this->validator->assertValid($attributes);

        $policy = new Rule($attributes);
        $policy->save();

        $this->clearCache();

        return $policy;
    }

    public function update(Rule $rule, array $attributes)
    {
        $this->validator->assertValid($attributes);

        $rule->fill($attributes);
        $rule->save();

        $this->clearCache();

        return $rule;
    }

    public function delete(Rule $rule)
    {
        $res = $rule->delete();

        $this->clearCache();

        return $res;
    }

    public function sorting(array $sorting)
    {
        foreach ($sorting as $i => $fieldId) {
            $this->rule->where('id', $fieldId)->update(['sort' => $i]);
        }

        $this->clearCache();
    }
}
