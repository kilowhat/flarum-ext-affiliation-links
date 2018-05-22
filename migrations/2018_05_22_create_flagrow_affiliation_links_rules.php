<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema) {
        $schema->create('flagrow_affiliation_links_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sort')->nullable()->index();
            $table->string('match_component');
            $table->string('match_type');
            $table->string('match_pattern');
            $table->string('replacement');
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    },
    'down' => function (Builder $schema) {
        $schema->drop('flagrow_affiliation_links_rules');
    },
];
