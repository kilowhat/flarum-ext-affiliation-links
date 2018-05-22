<?php

namespace Flagrow\AffiliationLinks\Controllers;

use Flagrow\AffiliationLinks\Repositories\RuleRepository;
use Flarum\Api\Controller\AbstractDeleteController;
use Flarum\Core\Access\AssertPermissionTrait;
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

        $id = array_get($request->getQueryParams(), 'id');

        $field = $this->rules->findOrFail($id);

        $this->rules->delete($field);
    }
}
