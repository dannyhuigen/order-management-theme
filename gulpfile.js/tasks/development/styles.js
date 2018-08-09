var gulp         = require('gulp'),
    gutil        = require('gulp-util'),
    concat       = require('gulp-concat'),
    autoprefixer = require('gulp-autoprefixer'),
    handleErrors = require('../util/handleErrors'),
    purge        = require('gulp-css-purge'),
    //scsslint     = require('gulp-scss-lint'),
    sourcemaps   = require('gulp-sourcemaps'),
    plumber      = require('gulp-plumber'),
    bulkSass     = require('gulp-sass-bulk-import'),
    sass         = require('gulp-sass'),
    sassGlob = require('gulp-sass-glob');

var autoPrefixBrowserList = ['last 2 version', 'safari 5','ie 9', 'opera 12.1', 'ios 6', 'android 4'];

var onError = function (err) {
    console.log('An error occurred:', gutil.colors.magenta(err.message));
    gutil.beep();
    this.emit('end');
};

//compiling our SCSS files
gulp.task('styles', function() {

    //the initializer / master SCSS file, which will just be a file that imports everything
    return gulp.src('styles/scss/init.scss')

        .pipe(sassGlob())

        .pipe(plumber({ errorHandler: onError }))
        //.pipe(sourcemaps.init())
        //.pipe(scsslint())
        .pipe(sass({
            errLogToConsole: true,
            includePaths: [
                'styles/scss/'
            ]
        }))



        .pipe(autoprefixer({
            browsers: autoPrefixBrowserList,
            cascade:  true
        }))

        //the final filename of our combined css file
        //.pipe(sourcemaps.write('maps'))
        .pipe(concat('styles.css'))

        .pipe(purge())

        //where to save our final, compressed css file
        .pipe(gulp.dest('styles'))


});

//compiling our SCSS files
gulp.task('grid', function() {

    //the initializer / master SCSS file, which will just be a file that imports everything
    return gulp.src('styles/scss/project/grid.scss')

        .pipe(plumber({ errorHandler: onError }))
        .pipe(sourcemaps.init())
        .pipe(scsslint())
        .pipe(sass({
            errLogToConsole: true,
            includePaths: [
                'styles/scss/project/'
            ]
        }))

        .pipe(autoprefixer({
            browsers: autoPrefixBrowserList,
            cascade:  true
        }))

        //the final filename of our combined css file
        .pipe(concat('grid.css'))

        //where to save our final, compressed css file
        .pipe(gulp.dest('styles'))


});