<?php

namespace Kilowhat\AffiliationLinks\Controllers;

use Flarum\Api\Controller\AbstractListController;
use Flarum\User\AssertPermissionTrait;
use Kilowhat\AffiliationLinks\Repositories\RuleRepository;
use Kilowhat\AffiliationLinks\Serializers\RuleSerializer;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class RuleIndexController extends AbstractListController
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
