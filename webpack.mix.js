let mix = require('laravel-mix');
let path = require('path');
function resolve (dir) {
  return path.join(__dirname, dir);
}

mix.webpackConfig({
  module: {
    rules: [
      {
        test: /\.(js|vue)$/,
        enforce: 'pre',
        include: resolve('resources/assets'),
        use: [{
          loader: 'eslint-loader',
          options: {
            formatter: require('eslint-friendly-formatter')
          }
        }]
      }
    ]
  }
});

// 如果网站不是更目录 setResourceRoot 设置路径
// mix.setResourceRoot('/')
mix.copy('resources/assets/backend/static/images/default_avatar.jpg', 'public/static/images/default_avatar.jpg')
    .js('resources/assets/backend/app.js', 'public/js/backend').version();

mix.less('resources/assets/frontend/less/app.less', 'public/static/css')
    .js('resources/assets/frontend/js/app.js', 'public/static/js')
    .copy('resources/assets/frontend/images', 'public/static/images')
    .version();

