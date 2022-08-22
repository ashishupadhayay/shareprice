"use strict";

const config = require('./gulpfile-config.json');
const gulp = require('gulp');
const plumber = require('gulp-plumber');
const sass = require('gulp-sass')(require('sass'));
const browsersync = require('browser-sync').create();
const rename = require('gulp-rename');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');

// BrowserSync
function browserSync(done) {
  browsersync.init({
    proxy: config.browsersync.proxy
  });
  done();
}

// BrowserSync Reload
function browserSyncReload(done) {
  browsersync.reload();
  done();
}

// CSS
function css() {
  return gulp
    .src(config.css.src)
    .pipe(plumber())
    .pipe(sass({ outputStyle: 'expanded' }))
    .pipe(gulp.dest(config.css.dest))
    .pipe(rename({ suffix: '.min' }))
    .pipe(postcss([autoprefixer(), cssnano()]))
    .pipe(gulp.dest(config.css.dest))
    .pipe(browsersync.stream());
}

// Watch
function watchFiles() {
  gulp.watch(config.css.src, css);
  gulp.watch(config.file.src, gulp.series(browserSyncReload));
}

const watch = gulp.parallel(watchFiles, browserSync);
exports.watch = watch;