const path = require('path');

const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");

const { CleanWebpackPlugin } = require('clean-webpack-plugin');

module.exports = [
  {
    entry: {
      'main': [
        './js/src/main.js',
        './css/src/main.scss'
      ]
    },
    output: {
      filename: './js/build/[name].min.[fullhash].js',
      path: path.resolve(__dirname)
    },
    module: {
      rules: [
        {
          test: /\.(js|jsx)$/,
          exclude: /node_modules/,
          loader: 'babel-loader'
        },
        {
          test: /\.(sass|scss)$/,
          use: [MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader']
        },
        {
          test: /\.(woff|woff2|eot|ttf|otf)$/,
          type: 'asset/resource',
          generator: {
            filename: './css/build/font/[name][ext]',
          }
        },
        {
          test: /\.(png|jpg|gif)$/,
          type: 'asset/resource',
          generator: {
            filename: './css/build/img/[name][ext]',
          }
        },
      ]
    },
    plugins: [
      new CleanWebpackPlugin({
        cleanOnceBeforeBuildPatterns: [
          './js/build/*',
          './css/build/*'
        ]
      }),
      new MiniCssExtractPlugin({
        filename: './css/build/main.min.[fullhash].css'
      }),
    ],
    optimization: {
      minimizer: [
        `...`,
        new CssMinimizerPlugin(),
      ]
    },
  }
];
