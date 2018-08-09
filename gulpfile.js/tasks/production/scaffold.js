var gulp        = require('gulp'),
    shell       = require('gulp-shell'),
    config      = require('../../../gulpconfig').directories;

//create folders using shell
gulp.task('scaffold', function() {
    return shell.task([
            'mkdir '+config.production,
            'mkdir '+config.production+'/fonts',
            'mkdir '+config.production+'/images',
            'mkdir '+config.production+'/scripts',
            'mkdir '+config.production+'/styles'
        ]
    );
});