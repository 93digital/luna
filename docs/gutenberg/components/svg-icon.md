# SVG Component
React component for displaying an `svg` element for React & Gutenberg development.

## Props

### `name`
Name of the svg icon. This can be found in the `assets/svg` directory and is the filename of the svg.

Type: `String`
Required: Yes

## Example
```js
import { SvgIcon } from './svg-icon';

// Uses icon_name.svg.
<SvgIcon name="icon_name" />
```

## Output
```html
<!-- Pulls icon_name svg from build/spritemap.svg -->
<svg class="svg-icon svg-icon--icon_name" role="img" aria-hidden="true">
  <use href="#sprite-icon_name"></use>
</svg>
```