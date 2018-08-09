var gulp         = require('gulp'),
    rename       = require('gulp-rename'),
    config       = require('../../../gulpconfig').directories;

//migrating over all HTML files for deployment
gulp.task('html-deploy', function() {
    //grab everything, which should include htaccess, robots, etc
    gulp.src([config.dev+'/*','!'+config.dev+'/.git','!'+config.dev+'/gulpfile.*','!'+config.dev+'/node_modules','!'+config.dev+'/gulpconfig.js','!'+config.dev+'/package.json','!'+config.dev+'/style.css'])
        .pipe(gulp.dest(config.production));

    //grab any hidden files too
    gulp.src([config.dev+'/.*','!'+config.dev+'gulpfile.*','!'+config.dev+'node_modules','!'+config.dev+'gulpconfig.js','!'+config.dev+'package.json','!'+config.dev+'style.css'])
        .pipe(gulp.dest(config.production));

    gulp.src(config.dev+'/fonts/**/*')
        .pipe(gulp.dest(config.production+'/fonts'));

    gulp.src(config.dev+'/buildingblocks/**/*')
        .pipe(gulp.dest(config.production+'/buildingblocks'));

    gulp.src(config.dev+'/templates/**/*')
        .pipe(gulp.dest(config.production+'/templates'));

    gulp.src(config.dev+'/acf/**/*')
        .pipe(gulp.dest(config.production+'/acf'));

    //grab all of the styles
    gulp.src([config.dev+'/styles/*.css', '!'+config.dev+'styles/styles.css'])
        .pipe(gulp.dest(config.production+'/styles'));

});