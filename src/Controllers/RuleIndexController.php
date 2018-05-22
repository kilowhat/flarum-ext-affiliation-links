<?php

namespace Flagrow\AffiliationLinks\Controllers;

use Flagrow\AffiliationLinks\Repositories\RuleRepository;
use Flagrow\AffiliationLinks\Serializers\RuleSerializer;
use Flarum\Api\Controller\AbstractCollectionController;
use Flarum\Core\Access\AssertPermissionTrait;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class RuleIndexController extends AbstractCollectionController
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

        return $this->rules->all();
    }
}
