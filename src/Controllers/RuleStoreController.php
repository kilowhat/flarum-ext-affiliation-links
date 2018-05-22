<?php

namespace Flagrow\AffiliationLinks\Controllers;

use Flagrow\AffiliationLinks\Repositories\RuleRepository;
use Flagrow\AffiliationLinks\Serializers\RuleSerializer;
use Flarum\Api\Controller\AbstractCreateController;
use Flarum\Core\Access\AssertPermissionTrait;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class RuleStoreController extends AbstractCreateController
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

        $attributes = array_get($request->getParsedBody(), 'data.attributes', []);

        return $this->rules->store($attributes);
    }
}
