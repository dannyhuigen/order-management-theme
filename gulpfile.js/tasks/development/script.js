var gulp         = require('gulp'),
    gutil        = require('gulp-util'),
    concat       = require('gulp-concat'),
    uglify       = require('gulp-uglify'),
    jshint       = require('gulp-jshint'),
    stylish      = require('jshint-stylish'),
    plumber      = require('gulp-plumber');

var onError = function (err) {
    console.log('An error occurred:', gutil.colors.magenta(err.message));
    gutil.beep();
    this.emit('end');
};

//compiling our Javascripts
gulp.task('scripts-app', function() {
    //this is where our dev JS scripts are
    return gulp.src(['scripts/helpers/*.js', 'scripts/behaviours/*.js'])
        //this is the filename of the compressed version of our JS
        .pipe(concat('app.js'))
        //catch errors
        .pipe(plumber({ errorHandler: onError }))

       // .pipe(uglify())

        //where we will store our finalized, compressed script
        .pipe(gulp.dest('scripts'))
});

//compiling our Javascripts
gulp.task('scripts-vendors', function() {
    //this is where our dev JS scripts are
    return gulp.src(['scripts/vendors/*.js'])

        .pipe(jshint.reporter('default'))
        //this is the filename of the compressed version of our JS
        .pipe(concat('vendors.js'))
        //catch errors
        .pipe(plumber({ errorHandler: onError }))
        //where we will store our finalized, compressed script
        .pipe(gulp.dest('scripts'))
});