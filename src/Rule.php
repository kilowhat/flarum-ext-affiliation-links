<?php

namespace Kilowhat\AffiliationLinks;

use Carbon\Carbon;
use Flarum\Database\AbstractModel;

/**
 * @property int $id
 * @property int $sort
 * @property string $match_component
 * @property string $match_type
 * @property string $match_pattern
 * @property string $replacement
 * @property string $comment
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Rule extends AbstractModel
{
    protected $table = 'kilowhat_affiliation_links_rules';

    public $timestamps = true;

    protected $visible = [
        'sort',
        'match_component',
        'match_type',
        'match_pattern',
        'replacement',
        'comment',
    ];

    protected $fillable = [
        'match_component',
        'match_type',
        'match_pattern',
        'replacement',
        'comment',
    ];

    protected function setCommentAttribute($value)
    {
        $this->attributes['comment'] = $value ? $value : null;
    }
}
