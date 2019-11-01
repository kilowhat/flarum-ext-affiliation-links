<?php

namespace Kilowhat\AffiliationLinks\Controllers;

use Flarum\Api\Controller\AbstractListController;
use Flarum\User\AssertPermissionTrait;
use Illuminate\Support\Arr;
use Kilowhat\AffiliationLinks\Repositories\RuleRepository;
use Kilowhat\AffiliationLinks\Serializers\RuleSerializer;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class RuleOrderController extends AbstractListController
{
    use AssertPermissionTrait;

    public $serializer = RuleSerializer::class;

    protected $rules;

    public function __construct(RuleRepository $rules)
    {
        $this->rules = $rules;
    }

    protected function data(ServerRequestInterface $request, Document $document)
    {
        $this->assertAdmin($request->getAttribute('actor'));

        $attributes = $request->getParsedBody();

        $this->rules->sorting(Arr::get($attributes, 'sort'));

        // Return updated sorting values
        return $this->rules->all();
    }
}
