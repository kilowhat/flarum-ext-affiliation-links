<?php

namespace Kilowhat\AffiliationLinks\Controllers;

use Flarum\Api\Controller\AbstractDeleteController;
use Flarum\User\AssertPermissionTrait;
use Illuminate\Support\Arr;
use Kilowhat\AffiliationLinks\Repositories\RuleRepository;
use Psr\Http\Message\ServerRequestInterface;

class RuleDeleteController extends AbstractDeleteController
{
    use AssertPermissionTrait;

    protected $rules;

    public function __construct(RuleRepository $rules)
    {
        $this->rules = $rules;
    }

    protected function delete(ServerRequestInterface $request)
    {
        $this->assertAdmin($request->getAttribute('actor'));

        $id = Arr::get($request->getQueryParams(), 'id');

        $field = $this->rules->findOrFail($id);

        $this->rules->delete($field);
    }
}
