<?php

namespace Flagrow\AffiliationLinks\Validators;

use Flarum\Core\Validator\AbstractValidator;

class RuleValidator extends AbstractValidator
{
    protected function getRules()
    {
        return [
            'match_component' => 'required|in:uri,host,path',
            'match_type' => 'required|in:exact,simple,regex',
            'match_pattern' => 'required|string',
            'replacement' => 'required|string',
            'comment' => 'sometimes|string',
        ];
    }
}
