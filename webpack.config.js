const path = require('path');

module.exports = {
  entry: {
    common: './src/js/common.js',
    'front-page': './src/js/front-page.js',
    page: './src/js/page.js',
    post: './src/js/post.js',
    shops: './src/js/shops.js',
  },
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, 'dist/js'),
  },
  module: {
    rules: [
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
    extensions: ['.js'],
  },
};
