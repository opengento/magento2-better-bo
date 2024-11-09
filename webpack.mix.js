/**
 * Webpack Mix configuration for Vuetificator
 * Please check the documentation for more information :
 * 
 * @see https://laravel-mix.com/docs/6.0
 * 
 * @version 1.0.0
 * @package Boeki\Vuetificator
 * 
 * @author <Alexandre Buleté> - bulete.alexandre@gmail.com
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


require('laravel-mix-purgecss');

mix.sass('adminhtml/web/scss/app.scss', 'adminhtml/web/css/')
    .purgeCss({
        extend: {
            content: [
                '../../../../../app/**/*.xml',
                '../../../../../app/**/*.js',
                '../../../../../app/**/*.html',
                '../../../../../app/**/*.phtml',
                '../../../../../app/**/*.php',
                // '../../../../../vendor/magento/**/*.xml',
                // '../../../../../vendor/magento/**/*.js',
                // '../../../../../vendor/magento/**/*.html',
                // '../../../../../vendor/magento/**/*.phtml',
                // '../../../../../vendor/magento/**/*.php'
            ],
            // defaultExtractor: (content) => content.match(/[\w-/.:]+(?<!:)/g) || [],
            defaultExtractor: (content) => content.match(/[A-z0-9-:%+<>.!?\/]+/g) || [],
            safelist: { 
                standard: [],
            deep: []},
            variables: false,
            fontFace: false
        },
        // enabled: true
    });


/**
 * Mix configuration example
 */
mix
    .ts('view/adminhtml/web/ts/catalog/product/attributes.ts', 'view/adminhtml/web/js/catalog/product/attributes')
    .vue({ version: 3 })
    .sass('view/adminhtml/web/scss/app.scss', 'view/adminhtml/web/css/')