# LunaButton
Link button component.

## Props

### url
URLto the desired location.

- Type: `String`
- Required: No

### label
The button label, text that appears inside the button.

- Type: `String`
- Required: No

### target
Toggle whether the button opens in a new tab

- Type: `Boolean`
- Required: Yes
- Default: `false`

### className
Add custom class name for the button element.

- Type: `String`
- Required: No

### onLabelChange
Function to update the button label on change.

- Type: `Function`
- Required: Yes

### onInputChange
Function to update the button url on input change.

- Type: `Function`
- Required: Yes
### onTargetChange
Function to update the button target on change.

- Type: `Function`
- Required: Yes

### Usage
```javascript
registerBlockType('luna/blockname', {
	...
	attributes: {
    buttonURL: {
			type: 'string'
		},
		buttonLabel: {
			type: 'string',
			source: 'html',
		},
		buttonTarget: {
			type: 'boolean',
			default: false
		},
	},
  ...
});

// edit.js
<LunaButton
	className="custom-class-name button"
	url={ buttonURL }
	label={ buttonLabel }
	target={ buttonTarget }
	onLabelChange={ value => setAttributes({ buttonLabel: value }) }
	onInputChange={ value => setAttributes({ buttonURL: value }) }
	onTargetChange={ value => setAttributes({ buttonTarget: value }) }
/>

// save.js
<LunaButton.Content
	className="custom-class-name button"
	url={ buttonURL }
	label={ buttonLabel }
	target={ buttonTarget }
/>
```

### Output
```html
<!-- Open in same window -->
<a href="#" class="custom-class-name button">button label</a>

<!-- Open in new tab -->
<a href="#" target="_blank" rel="noopener noreferrer" class="custom-class-name button">button label</a>
```
