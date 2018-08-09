var gulp        = require('gulp'),
    config      = require('../../../gulpconfig').directories;

// delete style.css
gulp.task('cwd', function() {

    console.log('Current directory: ' + process.cwd());
    process.chdir('../');
    console.log('Current directory: ' + process.cwd());

});