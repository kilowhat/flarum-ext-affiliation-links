<?php

namespace Flagrow\AffiliationLinks\Serializers;

use Flarum\Api\Serializer\AbstractSerializer;

class RuleSerializer extends AbstractSerializer
{
    protected $type = 'flagrow-affiliation-links-rules';

    protected function getDefaultAttributes($model)
    {
        return $model->toArray();
    }
}
