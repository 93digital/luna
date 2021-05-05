# PostItem & PostItemPreview
React components for displaying a selected post object.

## Post Item
Displays a simple card view of a post item.

### Props

#### id
Unique ID for post item.

- Type: `String`
- Required: No

#### suggestion
The selected post object, can be added via the REST api.

- Type: `Object`
- Required: Yes

#### onClick
On post item click.

- Type: `Function`
- Required: No

#### searchTerm
Adds highlighted text on the post item if used in a search query.

- Type: `String`
- Required: No

#### isSelected
If true adds `is-selected` class to item.

- Type: `String`
- Required: No
- Default: `false`

### Usage
```javascript
<PostItem
  id={ uniqueID }
  suggested={ postObject }
  onClick={ () => { console.log( 'Item clicked' ) } }
  searchTerm={ 'Highlight' }
  isSelected={ false }
/>
```

## Post Item Preview
Displays a preview of a post item card with a defined label.

### Props

#### post
The selected post object, can be added via the REST api.

- Type: `Object`
- Required: Yes

#### label
Label for the previewed post item. Will default to `Selected Post:`.

- Type: `String`
- Required: No
- Default: `Selected Post:`

#### onRemove
Adds remove button so the user can update the postObject.

- Type: `Function`
- Required: Yes

### Usage
```javascript
<PostItemPreview
  post={ postObject }
  label={ __('Selected Post:', 'luna') }
  onRemove={ setAttributes({ postObject: null }) }
/>
```