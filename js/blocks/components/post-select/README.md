# PostSelect
Post object search functionality. Will use the REST Api to filter results based on the search input, on select it returns a post object.

## Props

### label
Label for the search component.

- Type: `String`
- Required: No

### postTypes
An array of WordPress posts types you wish to search from.

- Type: `Array`
- Required: No
- Default: `[ 'posts', 'pages' ]`

### placeholder
Input placeholder for the post search field.

- Type: `String`
- Required: No

### onSelectPost
Function to set our 'object' attribute and store the selected post object.

- Type: `Function`
- Required: No


### Usage
```javascript
registerBlockType('luna/blockname', {
	...
	attributes: {
    selectedPost: {
      type: 'object'
		},
	},
  ...
});

<PostSelect 
  label={ __('Search page/post', 'luna') }
  postTypes={ [ 'posts', 'pages', 'custom-cpt' ] }
  placeholder={ __('Input placeholder', 'luna') }
  onSelectPost={ post => setAttributes({ selectedPost: post }) }
/>
```
