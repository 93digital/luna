/* eslint-disable */
module.exports = {
  plugins: [
    require('@fullhuman/postcss-purgecss')({
      content: [ '*.js', '*.php', '*.html', '**/*.js', '**/*.php', '**/*.html' ],
      keyframes: true,
      fontFace: true,
      variables: true,
    }),
    require('postcss-preset-env')({ stage: 0 }),
    require('cssnano'),
    require('postcss-pxtorem')({
      mediaQuery: true,
    }),
  ],
};

