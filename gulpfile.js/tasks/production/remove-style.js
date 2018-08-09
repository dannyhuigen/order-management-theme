var gulp        = require('gulp'),
    shell       = require('gulp-shell'),
    del         = require('del'),
    config      = require('../../../gulpconfig').build;

// delete style.css
gulp.task('remove-style', function() {

    console.log('Current directory: ' + process.cwd());
    process.chdir(config.path);
    console.log('Current directory: ' + process.cwd());

    del('style.css',function (err, deletedFiles) {
        console.log('Files deleted:', deletedFiles.join(', '));
    });

    console.log('Current directory: ' + process.cwd());

});