var gulp        = require('gulp'),
    config      = require('../../../gulpconfig').directories;

//compressing images & handle SVG files
gulp.task('images-deploy', function() {
    gulp.src([config.dev+'/images/**/*', '!'+config.dev+'/images/README'])
        .pipe(gulp.dest(config.production+'/images'));
});