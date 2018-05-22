<?php

namespace Flagrow\AffiliationLinks\Controllers;

use Flagrow\AffiliationLinks\Repositories\RuleRepository;
use Flagrow\AffiliationLinks\Serializers\RuleSerializer;
use Flarum\Api\Controller\AbstractResourceController;
use Flarum\Core\Access\AssertPermissionTrait;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class RuleUpdateController extends AbstractResourceController
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

        $id = array_get($request->getQueryParams(), 'id');

        $policy = $this->rules->findOrFail($id);

        $attributes = array_get($request->getParsedBody(), 'data.attributes', []);

        return $this->rules->update($policy, $attributes);
    }
}
