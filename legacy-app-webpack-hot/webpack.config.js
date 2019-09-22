const path = require('path');
const webpack = require('webpack');

module.exports = {
  //production|development|none
  mode: 'development',
  entry: {
    app: ['./assets/js/app.js', 'webpack/hot/dev-server',
  'webpack-dev-server/client?http://localhost:8765/',]
  },
  output: {
    path: path.resolve(__dirname, 'public', 'dist'),
    filename: '[name].bundle.js',
    publicPath: 'http://localhost:8765/dist/'
  },
  module: {
      rules: [
        // global CSS
        {
            test: /\.css$/i,
            use: [
                'style-loader',
                {
                    loader: 'css-loader',
                    options: {
                        modules: false,
                        sourceMap: process.env.NODE_ENV !== 'production',
                    },
                }
            ]
        },
    ]
  },
  // require package webpack-dev-server
  devServer: {
    contentBase: "./public",
    host: '0.0.0.0',
    port: 8765,
    hot: true, // this enables hot reload
    headers: {
        'Access-Control-Allow-Origin': '*'
    }
  },
  plugins: [ 
    new webpack.HotModuleReplacementPlugin()
  ]
};
