let mix = require('laravel-mix');
require("laravel-mix-purgecss");
let Vue = require("vue");
const fs = require("fs");
var JavaScriptObfuscator = require('javascript-obfuscator');

const tailwindcss = require('tailwindcss');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */
// mix
//   .js("resources/js/app.js", "public/js")
//   .sass("resources/sass/app.scss", "public/css/tailwind.css")
//   .options({
//     processCssUrls: false,
//     postCss: [tailwindcss("./tailwind.config.js")]
//   })
//   .purgeCss();
  //  mix.js('resources/js/app.js', 'public/js')
  //   .postCss('resources/css/tailwind.css', 'public/css/tailwind.css', [
  //       require('postcss-import'),
  //       // tailwindcss('./resources/css/tailwind.js'),
        
  //       require('tailwindcss')
  //   ]);
 require('sweetalert2');

  require('laravel-mix-tailwind');
    mix
    .postCss('resources/css/latest-tailwind.css', 'public/css', [
      require('tailwindcss'),
    ])
    .sass('resources/sass/app.scss', 'public/css')
    .options({
        processCssUrls: false,
        postCss: [
            tailwindcss('./resources/css/tailwind.config.js'),
            require('postcss-extend'),
            require('postcss-import'),
            require('tailwindcss')('./resources/css/tailwind.js')
        ],
    })
    .js('resources/js/app.js', 'public/js')
    // .copy('node_modules/sweetalert/dist', 'public/css')
    .copy('node_modules/sweetalert2/dist/sweetalert2.js', 'public/js/sweetalert2.js')
    .copy('node_modules/sweetalert2/dist/sweetalert2.css', 'public/js/sweetalert2.css')
    .copy('node_modules/bootstrap-sweetalert/dist/sweetalert.css', 'public/js/sweetalert-bootstrap.css')
    .copy('node_modules/bootstrap-sweetalert/dist/sweetalert.js', 'public/js/sweetalert-bootstrap.js')
    .copy('node_modules/bootstrap-sweetalert/dist/sweetalert.min.js', 'public/js/sweetalert-bootstrap.min.js')
    .copy('node_modules/wdt-loading/wdtLoading.js', 'public/js/wdtLoading.js')
    .copy('node_modules/wdt-loading/wdtLoading.css', 'public/js/wdtLoading.css')
    .copy('node_modules/viewerjs/dist/viewer.min.css', 'public/css/viewer.min.css')
    .copy('node_modules/viewerjs/dist/viewer.css', 'public/css/viewer.css')
    .copy('node_modules/viewerjs/dist/viewer.js', 'public/js/viewer.js')
    .copy('node_modules/javascript-obfuscator/dist/index.browser.js', 'public/js/obfuscator.js')
    .copy('node_modules/kleur/index.js', 'public/js/kleur.js')
    .version();

    if (process.env.MIX_APP_ENV === 'production') {
      Vue.config.devtools = false;
      Vue.config.debug = false;
      Vue.config.silent = true; 
  }
    
  // mix
  //     .js('resources/js/app.js', 'public/js')
  //     .less('resources/less/app.less', 'public/css')
  //     .tailwind();

//       const tailwindcss = require('tailwindcss')
// mix
//       .js('resources/js/app.js', 'public/js')
//     .less('resources/less/app.less', 'public/css')
//   .options({
//     postCss: [
//       tailwindcss('./resources/css/tailwind.config.js'),
//     ]
  // })
  /**
   * latest
   */
  // mix
  //   .sass('resources/assets/sass/app.scss', 'public/css')
  //   .options({
  //       processCssUrls: false,
  //       postCss: [
  //           tailwind('tailwind.config.js'),
  //           require('postcss-extend')
  //       ],
  //   })

  //   .js('resources/js/app.js', 'public/js')

  //   .version();
  /** end latest */
  // mix.js('resources/js/app.js', 'public/js')
  //  .sass('resources/assets/sass/app.scss', 'public/css');
  //  .setPublicPath('dist');
// mix.js('src/app.js', 'dist/').sass('src/app.scss', 'dist/');

// Full API
// mix.js(src, output);
// mix.react(src, output); <-- Identical to mix.js(), but registers React Babel compilation.
// mix.preact(src, output); <-- Identical to mix.js(), but registers Preact compilation.
// mix.coffee(src, output); <-- Identical to mix.js(), but registers CoffeeScript compilation.
// mix.ts(src, output); <-- TypeScript support. Requires tsconfig.json to exist in the same folder as webpack.mix.js
// mix.extract(vendorLibs);
// mix.sass(src, output);
// mix.less(src, output);
// mix.stylus(src, output);
// mix.postCss(src, output, [require('postcss-some-plugin')()]);
// mix.browserSync('my-site.test');
// mix.combine(files, destination);
// mix.babel(files, destination); <-- Identical to mix.combine(), but also includes Babel compilation.
// mix.copy(from, to);
// mix.copyDirectory(fromDir, toDir);
// mix.minify(file);
// mix.sourceMaps(); // Enable sourcemaps
// mix.version(); // Enable versioning.
// mix.disableNotifications();
// mix.setPublicPath('path/to/public');
// mix.setResourceRoot('prefix/for/resource/locators');
// mix.autoload({}); <-- Will be passed to Webpack's ProvidePlugin.
// mix.webpackConfig({}); <-- Override webpack.config.js, without editing the file directly.
// mix.babelConfig({}); <-- Merge extra Babel configuration (plugins, etc.) with Mix's default.
// mix.then(function () {}) <-- Will be triggered each time Webpack finishes building.
// mix.override(function (webpackConfig) {}) <-- Will be triggered once the webpack config object has been fully generated by Mix.
// mix.dump(); <-- Dump the generated webpack config object to the console.
// mix.extend(name, handler) <-- Extend Mix's API with your own components.
// mix.options({
//   extractVueStyles: false, // Extract .vue component styling to file, rather than inline.
//   globalVueStyles: file, // Variables file to be imported in every component.
//   processCssUrls: true, // Process/optimize relative stylesheet url()'s. Set to false, if you don't want them touched.
//   purifyCss: false, // Remove unused CSS selectors.
//   terser: {}, // Terser-specific options. https://github.com/webpack-contrib/terser-webpack-plugin#options
//   postCss: [] // Post-CSS options: https://github.com/postcss/postcss/blob/master/docs/plugins.md
// });

// mix.js('resources/js/app.js', 'public/js')
//  .postCss('resources/sass/app.css', 'public/css', [
//    tailwindcss('./tailwind.js'),
//   ]);

//    mix.js('resources/js/app.js', 'public/js')
//     .postCss('resources/css/tailwind.css', 'public/css/tailwind.css', [
//         require('postcss-import'),
//         require('tailwindcss'),
//     ]);
