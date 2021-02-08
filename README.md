# Luna Starter Theme
93Digital's development starter theme, the boilerplate for all our WordPress projects.

## Node
Use node version 14 or higher.

## NPM
This theme uses npm to include third party modules as well as for bundling assets. This theme requires npm version 6 or higher. To install the theme dependencies, run: `npm install` or `npm i`.

### Scripts
NPM Scripts needed to run during development & before deployment.

#### Build (Build)
Build JS & SASS files ready for production. It runs several PostCSS plugins for optimisation.
`npm run build`

#### Watch (Development)
Watches JS & SASS files and generates development friendly assets not meant for production.
`npm run watch`

## Stylelint
Extends on Stylelint SASS config [Stylelint](https://github.com/bjankord/stylelint-config-sass-guidelines). See `.stylelintrc.json` for more details.

## ESlint
Extends on ESlint reccomended & react config [ESLint](https://eslint.org/). See `.eslintrc.json` for more details.

## PostCSS
We use several PostCSS plugins to enhance our CSS and allow us to use the very latest features. See `postcss.config.js` for the full list.