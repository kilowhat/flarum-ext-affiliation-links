<?php

namespace Kilowhat\AffiliationLinks\Serializers;

use Flarum\Api\Serializer\AbstractSerializer;

class RuleSerializer extends AbstractSerializer
{
    protected $type = 'kilowhat-affiliation-links-rules';

    protected function getDefaultAttributes($model)
    {
        return $model->toArray();
    }
}
