const gulp = require('flarum-gulp');

gulp({
    modules: {
        'flagrow/affiliation-links': [
            'src/**/*.js',
        ],
    },
});
