## PostItem & PostItemPreview
Post object components for displaying a selected post object.

## Post Item
Displays a simple card view of a post item.

### Component properties (`props`)

#### `id` - string
Unique ID for post item.

#### `suggestion` - object
The selected post object, can be added via the REST api.

#### `onClick` - function
On post item click.

#### `searchTerm` - string
Adds highlighted text on the post item if used in a search query.

#### `isSelected` - boolean
If true adds `is-selected` class to item.

### Usage
```js
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

### Component properties (`props`)

#### `label` - string
Label for the previewed post item.

#### `post` - object
The selected post object, can be added via the REST api.

### Usage
```js
<PostItemPreview
  label={ __( 'Selected Post:', 'luna' ) }
  post={ postObject }
/>
```