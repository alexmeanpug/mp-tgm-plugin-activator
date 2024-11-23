const path = require('path');
const { series, watch, parallel, src, dest } = require('gulp');
const cleanCSS = require('gulp-clean-css');
const postcss = require('gulp-postcss');
const nested = require('postcss-nested');
const autoprefixer = require('autoprefixer');
const babel = require('gulp-babel');
const uglify = require('gulp-uglify');
const rename = require('gulp-rename');

const themeRoot = path.resolve('theme');
const blockSources = path.resolve(themeRoot, 'blocks/');
const moduleSources = path.resolve(themeRoot, 'inc/modules/');
const outputDir = path.resolve(themeRoot, 'dist/');

function buildCss(cb) {
    return src(path.resolve(blockSources, '**/*.css'))
        .pipe(src(path.resolve(moduleSources, '**/*.css')))
        .pipe(postcss([nested, autoprefixer]))
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(rename({ extname: '.min.css' }))
        .pipe(dest(outputDir));
}

function buildJs(cb) {
    // body omitted
    return src(path.resolve(blockSources, '**/*.js'))
        .pipe(src(path.resolve(moduleSources, '**/*.js')))
        .pipe(babel())
        .pipe(uglify())
        .pipe(rename({ extname: '.min.js' }))
        .pipe(dest(outputDir));
}

exports.default = parallel(buildJs, buildCss);
exports.dev = function devWatch() {
    watch(path.resolve(blockSources, '**/*.(css|js)'), parallel(buildJs, buildCss));
    watch(path.resolve(moduleSources, '**/*.(css|js)'), parallel(buildJs, buildCss));
};
