<?php

namespace Flagrow\AffiliationLinks\Controllers;

use Flagrow\AffiliationLinks\Repositories\RuleRepository;
use Flagrow\AffiliationLinks\Serializers\RuleSerializer;
use Flarum\Api\Controller\AbstractCollectionController;
use Flarum\Core\Access\AssertPermissionTrait;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class RuleOrderController extends AbstractCollectionController
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

        $this->rules->sorting(array_get($attributes, 'sort'));

        // Return updated sorting values
        return $this->rules->all();
    }
}
