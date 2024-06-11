import path from 'path';
import fs from 'fs';
import { glob } from 'glob';
import { src, dest, watch, series } from 'gulp';
import * as dartSass from 'sass';
import gulpSass from 'gulp-sass';
import terser from 'gulp-terser';
import sharp from 'sharp';
import plumber from 'gulp-plumber';

const sass = gulpSass(dartSass);

const paths = {
    scss: 'src/scss/**/*.scss',
    js: 'src/js/**/*.js'
};

export function css(done) {
    src(paths.scss, { sourcemaps: true })
        .pipe(plumber())  // Add plumber here
        .pipe(sass({
            outputStyle: 'compressed'
        }).on('error', sass.logError))
        .pipe(dest('./public/build/css', { sourcemaps: '.' }));
    done();
}

export function js(done) {
    src(paths.js)
        .pipe(plumber())  // Add plumber here
        .pipe(terser())
        .pipe(dest('./public/build/js'));
    done();
}

export async function images(done) {
    try {
        const srcDir = './src/img';
        const buildDir = './public/build/img';
        const images = await glob('./src/img/**/*');

        images.forEach(file => {
            const relativePath = path.relative(srcDir, path.dirname(file));
            const outputSubDir = path.join(buildDir, relativePath);
            processingImages(file, outputSubDir);
        });

        done();
    } catch (err) {
        console.error(err);
        done();
    }
}

function processingImages(file, outputSubDir) {
    if (!fs.existsSync(outputSubDir)) {
        fs.mkdirSync(outputSubDir, { recursive: true });
    }
    const baseName = path.basename(file, path.extname(file));
    const extName = path.extname(file);

    if (extName.toLowerCase() === '.svg') {
        const outputFile = path.join(outputSubDir, `${baseName}${extName}`);
        fs.copyFileSync(file, outputFile);
    } else {
        const outputFile = path.join(outputSubDir, `${baseName}${extName}`);
        const outputFileWebp = path.join(outputSubDir, `${baseName}.webp`);
        const outputFileAvif = path.join(outputSubDir, `${baseName}.avif`);
        const options = { quality: 80 };

        sharp(file).jpeg(options).toFile(outputFile).catch(console.error);
        sharp(file).webp(options).toFile(outputFileWebp).catch(console.error);
        sharp(file).avif().toFile(outputFileAvif).catch(console.error);
    }
}

export function dev() {
    watch(paths.scss, css).on('error', console.error);
    watch(paths.js, js).on('error', console.error);
    watch('src/img/**/*.{png,jpg}', images).on('error', console.error);
}

export default series(js, css, images, dev);