var gulp        = require('gulp'),
    del         = require('del'),
    config      = require('../../../gulpconfig').directories;

//cleans our dist directory in case things got deleted
gulp.task('clean', function() {

    del('vaneps_production', { force: true } ,function (err, deletedFiles) {
        console.log('Files deleted:', deletedFiles.join(', '));
    });

});