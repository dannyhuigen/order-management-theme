//initialize all of our variables
var app, base, concat, directory, gulp, gutil, hostname, path, refresh, uglify, del, connect, autoprefixer, gulpSequence, shell, plumber;

//load all of our dependencies
//add more here if you want to include more libraries
gulp        = require('gulp');
gulpSequence = require('gulp-sequence').use(gulp);

var onError = function (err) {
    console.log('An error occurred:', gutil.colors.magenta(err.message));
    gutil.beep();
    this.emit('end');
};


//this is our master task when you run `gulp` in CLI / Terminal
//this is the main watcher to use when in active development
//  this will:
//  startup the web server,
//  compress all scripts and SCSS files
gulp.task('default', ['scripts-app','scripts-vendors', 'styles'], function() {
    //a list of watchers, so it will watch all of the following files waiting for changes
    gulp.watch('scripts/behaviours/**', ['scripts-app']);
    gulp.watch('scripts/helpers/**', ['scripts-app']);
    gulp.watch('scripts/vendors/**', ['scripts-vendors']);

    gulp.watch('styles/scss/**', ['styles']);
    gulp.watch('*.html', ['html']);
});

gulp.task('grid', ['grid'], function() {
    gulp.watch('styles/scss/project/grid.scss', ['grid']);
});

//this is our deployment task, it will set everything for deployment-ready files
gulp.task('build', gulpSequence('cwd','clean', 'scaffold', ['scripts-app-deploy','scripts-vendors-deploy', 'styles-deploy','images-deploy'], 'html-deploy'));

gulp.task('deploy', gulpSequence('build', 'rename-style'));
