const mix = require('laravel-mix');
const path = require('path');

mix.js('resources/js/app.js', 'public/js')
   .vue()
   .webpackConfig({
      module: {
         rules: [
            {
               test: /\.vue$/,
               loader: 'vue-loader',
            },
            {
               test: /\.js$/,
               exclude: /node_modules/,
               use: {
                  loader: 'babel-loader',
                  options: {
                     presets: ['@babel/preset-env'],
                  },
               },
            },
         ],
      },
      resolve: {
         alias: {
            '@': path.resolve(__dirname, 'resources/js'),
         },
      },
   });
