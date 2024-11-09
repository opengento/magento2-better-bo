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


/**
 * Mix configuration example
 */
mix
    .ts('view/adminhtml/web/ts/catalog/product/attributes.ts', 'view/adminhtml/web/js/catalog/product')
    .vue({ version: 3 })