var gulp         = require('gulp'),
    concat       = require('gulp-concat'),
    autoprefixer = require('gulp-autoprefixer'),
    sass         = require('gulp-sass'),
    minifyCSS    = require('gulp-minify-css'),
    plumber      = require('gulp-plumber'),
    handleErrors = require('../util/handleErrors'),
    bulkSass     = require('gulp-sass-bulk-import'),
    config       = require('../../../gulpconfig').directories;

var autoPrefixBrowserList = ['last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'];

var onError = function (err) {
    console.log('An error occurred:', gutil.colors.magenta(err.message));
    gutil.beep();
    this.emit('end');
};

//compiling our SCSS files for deployment
gulp.task('styles-deploy', function() {
    //the initializer / master SCSS file, which will just be a file that imports everything

    return gulp.src(config.dev+'/styles/scss/init.scss')

        .pipe(bulkSass())

        .pipe(plumber({ errorHandler: onError }))

        //include SCSS includes folder
        .pipe(sass({
            includePaths: [
                config.dev+'/styles/scss'
            ]
        }))

        .pipe(autoprefixer({
            browsers: autoPrefixBrowserList,
            cascade:  true
        }))

        //the final filename of our combined css file
        .pipe(concat('styles.css'))

        .pipe(minifyCSS())

        //where to save our final, compressed css file
        .pipe(gulp.dest(config.production+'/styles'));
});