var gulp = require('gulp'),
    concat = require('gulp-concat'),
    sass = require('gulp-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    sourcemaps = require('gulp-sourcemaps'),
    minifyCss = require('gulp-minify-css'),
    rename = require('gulp-rename');

;
gulp.task('sass', function () {
    return gulp.src('./resources/assets/sass/main.sass')
        .pipe(sourcemaps.init())
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(minifyCss())
        .pipe(concat('main.css'))
        .pipe(rename({
            basename: 'main',
            extname: '.min.css'
        }))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./public/css/'));
});

gulp.task('watch', function () {
    gulp.watch('./resources/assets/sass/**/*.sass', ['sass']);
});