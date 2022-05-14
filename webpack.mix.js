const mix = require('laravel-mix');

mix.js('src/app.js', 'web/js').vue();
mix.sass('src/scss/app.scss', 'web/css');

mix.vue({
  "globalStyles": "src/scss/app.scss"
})
