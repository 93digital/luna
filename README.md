# Luna

***v1.1.7***

***Authors:*** *Andrew Iontton & Matt Knight*

A WordPress starter theme lovingly created by the 93digital development team. It is the boilerplate for all our WordPress projects from April 2021 onwards and replaces the older starter theme, Stella.

Luna aims to clean up a lot of the legacy code which had grown in Stella over the years whilst also reinventing the theme to natively allow Gutenberg block development.

## Installation

Luna is available on 93digital's private Bitbucket repository at `https://bitbucket.org/93developers/luna-starter-theme/` and can be cloned via `git clone git@93digital.git:wordpress/starter-theme.git`.

## Requirements

### PHP
Required PHP version 7.0 or later. Untested with version 8.

### Node
Use node version 14 or later.

### NPM
The theme uses npm to include third party modules as well as for bundling assets. This theme requires npm version 6 or later.

To install the theme dependencies, run: `npm install` or `npm i`.

### Composer
Composer is required to install third-party PHP packages. This is not imperative as the core theme does not depend on third-party packages, however the packages listed in `composer.json` will likely be useful with theme development.

To install Composer packages, run: `composer update`.

## Available npm scripts
Luna utilises WordPress's own wp-scripts for it's main development workflow. This uses Webpack to bundle assets together. Documentation on what is included can be found here. [WP Scripts](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-scripts/).

### npm build
Transform your code to provide it's ready for production and optimized, needed to run before deployment.

**Example:**
```json
{
  "scripts": {
    "build": "run-s \"build:*\"",
    "build:scripts": "wp-scripts build js/index.js js/blocks/blocks.js js/acf-blocks.js",
    "build:styles": "sass sass:",
    "build:postcss": "postcss -r style.css",
    "watch": "run-p \"watch:*\"",
    "watch:scripts": "wp-scripts start js/index.js js/blocks/blocks.js js/acf-blocks.js",
    "watch:styles": "sass --watch sass:"
  },
}
```

- `npm run build` - Builds the code for production (Runs through all scripts prepended with `build:`).
- `npm run build:scripts` - Builds the JavaScript assets ready for production.
- `npm run build:styles` - Builds the SASS assets ready for production.
- `npm run build:postcss` - Runs PostCSS through our main Theme and Editor stylesheets for better optimization. 


### npm watch
Watches your code and generates development friendly assets not meant for production. The script will automatically generate new files if you make changes.

**Example:**
```json
{
  "scripts": {
    "watch": "run-p \"watch:*\"",
    "watch:scripts": "wp-scripts start js/index.js js/blocks/blocks.js js/acf-blocks.js",
    "watch:styles": "sass --watch sass:"
  },
}
```

- `npm run watch` - Watches and builds the code for development (Runs through all scripts prepended with `watch:`).
- `npm run watch:styles` - Specifically watches only SASS assets. It does not run PostCSS like `build` to help with debugging.
- `npm run watch:scripts` - Specifically watches only JavaScript assets.

## Configurations

### Webpack
Extended the default wp-scripts to include svg spritemaps.

### Stylelint
Extends on Stylelint SASS config [Stylelint](https://github.com/bjankord/stylelint-config-sass-guidelines). See `.stylelintrc.json` for more details.

### ESlint
Extends on ESlint reccomended & react config [ESLint](https://eslint.org/). See `.eslintrc.json` for more details.

### PostCSS
We use several [PostCSS](https://postcss.org/) plugins to enhance our CSS and allow us to use the very latest features. See `postcss.config.js` for the full list.

### PHP Code Sniffer / WordPress PHP coding standards
@todo (https://make.wordpress.org/core/handbook/best-practices/coding-standards/php/ - needs configuring).

## Luna updates

When updating the core codebase of Luna, please update the theme version in the following places:

- The top of this file (`README.md`)
- `readme.txt` (Also add a brief summary of the changes to the Changelog)
- `/sass/style.scss` 
- `package.json`

Also, it is advised to call name the branch after the new version you are working on. So if the theme is currently at `v1.0.1` and your are fixing a bug, the branch for this bug should be `v1.0.2`. If multiple developers are working on different things at the same time then they will need to collaborate as to which version they are working on.
