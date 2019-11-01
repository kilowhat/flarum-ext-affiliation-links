<?php

use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema) {
        // Re-use the tables from the Flagrow version if they exist
        if ($schema->hasTable('flagrow_affiliation_links_rules') && !$schema->hasTable('kilowhat_affiliation_links_rules')) {
            $schema->rename('flagrow_affiliation_links_rules', 'kilowhat_affiliation_links_rules');
        }
    },
    'down' => function (Builder $schema) {
        // Not doing anything but `down` has to be defined
    },
];
