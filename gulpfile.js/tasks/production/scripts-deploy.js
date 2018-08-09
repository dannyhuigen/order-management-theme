var gulp         = require('gulp'),
    concat       = require('gulp-concat'),
    uglify       = require('gulp-uglify'),
    config      = require('../../../gulpconfig').directories,
    plumber      = require('gulp-plumber');

var onError = function (err) {
    console.log('An error occurred:', gutil.colors.magenta(err.message));
    gutil.beep();
    this.emit('end');
};

//compiling our Javascripts
gulp.task('scripts-app-deploy', function() {
    //this is where our dev JS scripts are
    return gulp.src([config.dev+'/scripts/helpers/*.js', config.dev+'/scripts/behaviours/*.js'])

        //this is the filename of the compressed version of our JS
        .pipe(concat('app.js'))
        .pipe(uglify())
        //catch errors
        .pipe(plumber({ errorHandler: onError }))
        //where we will store our finalized, compressed script
        .pipe(gulp.dest(config.production+'/scripts'));
});

//compiling our Javascripts
gulp.task('scripts-vendors-deploy', function() {
    //this is where our dev JS scripts are
    return gulp.src([config.dev+'/scripts/vendors/*.js'])

        //this is the filename of the compressed version of our JS
        .pipe(concat('vendors.js'))
        //catch errors
        .pipe(uglify())
        .pipe(plumber({ errorHandler: onError }))
        //where we will store our finalized, compressed script
        .pipe(gulp.dest(config.production+'/scripts'));
});