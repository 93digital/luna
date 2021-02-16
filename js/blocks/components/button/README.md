# LunaButton
Link button component.

## Props

### label
The button label, text that appears inside the button.

- Type: `String`
- Required: No

### url
URLto the desired location.

- Type: `String`
- Required: No

### title
Link title, adds `title` attribute to the link.

- Type: `String`
- Required: No

### target
Toggle whether the button opens in a new tab

- Type: `Boolean`
- Required: Yes
- Default: `false`

### expanded
- Type: `Boolean`
- Required: Yes
- Default: `false`


### Usage
```javascript
registerBlockType('luna/blockname', {
	...
	attributes: {
    url: {
			type: 'string'
		},
		title: {
			type: 'string',
			source: 'attribute',
			attribute: 'title'
		},
		label: {
			type: 'string',
			source: 'html',
		},
		target: {
			type: 'boolean',
			default: false
		},
		expanded: {
			type: 'boolean',
			default: false
		},
	},
  ...
});

// edit.js
<LunaButton
  url={ attributes.url }
  title={ attributes.title }
  label={ attributes.label }
  target={ attributes.target }
  expanded={ attributes.expanded }
  className="custom-button-class"
/>

// save.js
<LunaButtonSave
  url={ attributes.url }
  title={ attributes.title }
  label={ attributes.label }
  target={ attributes.target }
  className="custom-button-class"
/>
```
