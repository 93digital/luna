# Luna Starter Theme

WordPress starter theme by the 93Digital's development team, the boilerplate for all our WordPress projects.
Uses SASS, PostCSS, HTML5 & bundles using [WordPress scripts](https://github.com/WordPress/gutenberg/blob/223b5ea26f79eed0fd8bd278e692ce1f99645bc5/packages/scripts/README.md) & Webpack.

## Node
Use node version 14 or later.

## NPM
This theme uses npm to include third party modules as well as for bundling assets. This theme requires npm version 6 or later. 
To install the theme dependencies, run: `npm install` or `npm i`.

### Available Scripts

#### `build`
Transform your code to provide it's ready for production and optimized, needed to run before deployment.

*Example*
```json
{
  "scripts": {
    "build": "run-s \"build:*\"",
    "build:scripts": "wp-scripts build js/index.js js/blocks/blocks.js",
    "build:styles": "sass sass:",
    "build:postcss": "postcss -r style.css && postcss -r style-editor.css",
  },
}
```

- `npm run build` - builds the code for production (Runs through all scripts prepended with `build:`).
- `npm run build:scripts` - builds the JavaScript assets ready for production.
- `npm run build:styles` - builds the SASS assets ready for production.
- `npm run build:postcss` - Runs PostCSS through our main Theme and Editor stylesheets for better optimization. 


#### `watch`
Watches your code and generates development friendly assets not meant for production. The script will automatically generate new files if you make changes.

*Example*
```json
{
  "scripts": {
    "watch": "run-p \"watch:*\"",
    "watch:scripts": "wp-scripts start js/index.js js/blocks/blocks.js",
    "watch:styles": "sass --watch sass:"
  },
}
```

- `npm run watch` - watches and builds the code for development (Runs through all scripts prepended with `watch:`).
- `npm run watch:scripts` - specifically watches only JavaScript assets.
- `npm run watch:styles` - specifically watches only SASS assets. It does not run PostCSS like `build` to help with debugging code.

## Stylelint
Extends on Stylelint SASS config [Stylelint](https://github.com/bjankord/stylelint-config-sass-guidelines). See `.stylelintrc.json` for more details.

## ESlint
Extends on ESlint reccomended & react config [ESLint](https://eslint.org/). See `.eslintrc.json` for more details.

## PostCSS
We use several PostCSS plugins to enhance our CSS and allow us to use the very latest features. See `postcss.config.js` for the full list.

## Gutenberg Development
We have two main methods of Gutenberg development. Standard block creation using the default WordPress scripts and ACF (Advanced Custom Fields) Blocks.

### Standard block creation
Standard block creation utilizing the `@wordpress` gutenberg packages like `registerBlockType`. See the [Block Editor Handbook](https://developer.wordpress.org/block-editor/developers/) for more information.

*File Structure*
```
├── js
│   ├── blocks
│   │   ├── blocks
│   │   │   └── m01-example      // Single block directory.
│   │   │       ├── index.js     // Register block type.
│   │   │       ├── edit.js      // Edit function/output BackEnd.
│   │   │       ├── save.js      // Save function/output FrontEnd.
│   │   │       └── insepctor.js // Sidebar functionality.
│   │   ├── blocks.js            // Import blocks here.
│   │   └── unregister-styles.js // Unregister default block styles.
```

### ACF blocks
ACF blocks use custom fields allowing developers more familiar with PHP development to hit the ground running. See [ACF Blocks](https://www.advancedcustomfields.com/resources/blocks/) for more information.

*File Structure*
```
└── acf-blocks
    └── m01-example.php // Block code for both  Front & BackEnd.
```

## Advanced Usage

### Using SVG

*JavaScript (Gutenberg) Example*

```js
import { ReactComponent as Icon } from './icon.svg';

const App = () => (
  <article className="m01">
    <Icon />
  </article>
);
```

*PHP Example*

```php
<?php use function Luna\Icons\svg; ?>

<article class="m01">
  <?php svg( 'icon' ); ?>
</article>
?>
```