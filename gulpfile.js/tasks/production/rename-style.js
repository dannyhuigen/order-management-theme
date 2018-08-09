var gulp         = require('gulp'),
    rename       = require('gulp-rename'),
    config       = require('../../../gulpconfig').directories;

// rename style-production > style.css for production
gulp.task('rename-style', function() {

    gulp.src(config.dev+'/style-production.css')
        .pipe(rename('style.css'))
        .pipe(gulp.dest(config.production));
});


