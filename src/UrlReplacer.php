<?php

namespace Kilowhat\AffiliationLinks;

use Zend\Diactoros\Uri;

class UrlReplacer
{
    protected $rules = [];

    public function __construct(array $rules = [])
    {
        $this->rules = $rules;
    }

    public function addRule(Rule $rule)
    {
        $this->rules[] = [
            'component' => $rule->match_component,
            'type' => $rule->match_type,
            'pattern' => $rule->match_pattern,
            'replacement' => $rule->replacement,
        ];
    }

    protected function matchUri($uri, array $rule)
    {
        $compare = $uri;

        $pattern = $rule['pattern'];

        $parsedUri = new Uri($uri);

        switch ($rule['component']) {
            case 'host':
                $compare = $parsedUri->getHost();

                break;
            case 'path':
                $compare = $parsedUri->getPath();

                break;
        }

        $check = false;
        $matches = [];

        switch ($rule['type']) {
            case 'exact':
                $check = $compare === $pattern;

                break;
            case 'simple':
                $regex = '';

                if (starts_with($pattern, '*')) {
                    $regex .= '.*';
                }

                $parts = explode('*', $pattern);

                foreach ($parts as $key => $part) {
                    if ($key > 0) {
                        $regex .= '.*';
                    }

                    $regex .= preg_quote($part, '~');
                }

                if (ends_with($pattern, '*')) {
                    $regex .= '.*';
                }

                $check = preg_match("~^$regex$~", $compare, $matches) === 1;

                break;
            case 'regex':
                $check = preg_match($pattern, $compare, $matches) === 1;

                break;
        }

        if (!$check) {
            return null;
        }

        $matches['url'] = $uri;

        $values = [];

        foreach ($matches as $key => $match) {
            $values[$key] = urlencode($match);
            $values['raw' . $key] = $match;
        }

        return $values;
    }

    protected function replaceMatch(array $rule, array $matches)
    {
        $replaced = $rule['replacement'];

        foreach ($matches as $key => $value) {
            $replaced = str_replace('{' . $key . '}', $value, $replaced);
        }

        return $replaced;
    }

    /**
     * @param string $uri
     * @return string|null
     */
    public function replace($uri)
    {
        foreach ($this->rules as $rule) {
            $matches = $this->matchUri($uri, $rule);

            if ($matches) {
                return $this->replaceMatch($rule, $matches);
            }
        }

        return null;
    }
}
