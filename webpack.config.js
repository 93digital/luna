const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const SVGSpritemapPlugin = require('svg-spritemap-webpack-plugin');

module.exports = {
  ...defaultConfig,
  module: {
    ...defaultConfig.module
  },
  plugins: [
    ...defaultConfig.plugins,
    new SVGSpritemapPlugin('assets/svg/**/*.svg')
  ]
};