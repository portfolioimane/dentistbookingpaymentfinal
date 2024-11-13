const mix = require('laravel-mix');
const webpack = require('webpack');

mix.js('resources/js/app.js', 'public/js')
   .vue()
   .css('resources/css/app.css', 'public/css')
   .webpackConfig({
       plugins: [
           new webpack.DefinePlugin({
               // Define Vue feature flags here
               '__VUE_PROD_HYDRATION_MISMATCH_DETAILS__': JSON.stringify(true),
           }),
       ],
   });
