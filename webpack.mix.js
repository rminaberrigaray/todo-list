const mix = require('laravel-mix');

mix.setPublicPath('./webroot')
    .js('assets/js/app.js', 'webroot/js')
    .postCss("assets/css/app.css", "webroot/css", [
      require("tailwindcss"),
    ])
    .vue()
    .version();
