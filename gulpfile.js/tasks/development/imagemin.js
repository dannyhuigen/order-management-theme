var gulp         = require('gulp');
var imagemin    = require('gulp-imagemin');

//compressing images & handle SVG files
gulp.task('images', function(tmp) {
    console.log(tmp);
    gulp.src(['images/*.jpg', 'images/*.png'])
        .pipe(imagemin({ optimizationLevel: 5, progressive: true, interlaced: true }));
});