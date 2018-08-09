var gulp         = require('gulp');

//basically just keeping an eye on all HTML files
gulp.task('html', function() {
    //watch any and all HTML files and refresh when something changes
    return gulp.src(['*.html','*.php'])
        .pipe(connect.reload())
        //catch errors
        .on('error', gutil.log);
});