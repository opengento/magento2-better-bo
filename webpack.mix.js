/**
 * Webpack Mix configuration for Vuetificator
 * Please check the documentation for more information :
 * 
 * @see https://laravel-mix.com/docs/6.0
 * 
 */

const mix = require('laravel-mix');
require('laravel-mix-purgecss');

const path = require('path');

/**
 * Mix Aliases
 */
mix.alias({
    '@'         : path.join(__dirname, ''),
    '$c'        : path.join(__dirname, 'vue/components')
})

/**
 * Mix SASS
 */
mix
    .ts('view/adminhtml/web/ts/catalog/product/attributes.ts', 'view/adminhtml/web/js/catalog/product')
    .vue({ version: 3 })
    .sass('view/adminhtml/web/scss/app.scss', 'view/adminhtml/web/css/')
    .purgeCss({
        extend: {
            content: [
                './**/*.xml',
                './**/*.js',
                './**/*.html',
                './**/*.phtml',
                './**/*.php',
                './**/*.vue',
                './**/*.ts',
                './node_modules/element-plus/**/*.js',
            ],
            skippedContentGlobs: [
                '**/element-plus/**/*.css'
            ],
            defaultExtractor: (content) => content.match(/[A-z0-9-:%+<>.!?\/]+/g) || [],
            safelist: { 
                standard: [
                    /^el-/,
                    /^is-/,
                    /^user-select/,
                    /^popper/,
                    /^fade-in/,
                    /^zoom-in/,
                    /^slide/,
                ],
                deep: [/^el-/],
                greedy: [/^el-/]
            },
            variables: false,
            fontFace: false
        }
    });


// /**
//  * Mix TypeScript and Vue
//  */
// mix
//     // .ts('view/adminhtml/web/ts/catalog/product/attributes.ts', 'view/adminhtml/web/js/catalog/product')
//     .vue({ version: 3 })
//     // .sass('view/adminhtml/web/scss/app.scss', 'view/adminhtml/web/css/')
