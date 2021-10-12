# Drag Items
Components that allow for drag and drop functionality. Basic use case would be used in repeater elements. These components utilise (React Sortable HOC)[https://github.com/clauderic/react-sortable-hoc].

## Components

### SortableContainer
See (Documentation)[https://github.com/clauderic/react-sortable-hoc#sortablecontainer-hoc] for list of properties.

```jsx
// Usage:
<SortableContainer onSortEnd={ sortEndFunction } useDragHandle>
  ...
</SortableContainer>
```

### SortableItem
See (Documentation)[https://github.com/clauderic/react-sortable-hoc#sortableelement-hoc] for list of properties.

```jsx
// Usage:
{
  items.map((item, i) => {
    return (
      <SortableItem key={ `item-${ i }` } index={ i }>
        ...
      </SortableItem>
    )
  })
}
```

### DragHandle
Used within the SortableItem component. Setting useDragHandle to true on the `SortableItem` will display a draggable button element.

## Functions

### arrayMove (array, from, to).
Function that updates the current order of elements in an array. 
- Array: Array of sortable items
- From: Original index in array
- To: New index to move sortable item.

### sortEndFunction
Function that updates our block attributes array.

``` jsx
const sortEndFunction = ({ oldIndex, newIndex }) => {
  setAttributes({ items: arrayMove(caseStudies, oldIndex, newIndex) });
};
```

### AddNewItem
Function that adds a new item in array (Used mainly for repeater elements).

```jsx
const addNewItem = () => {
  if (items) {
    const newItems = [...items];

    newItems.push({
      postObject: null,
      title: '',
      excerpt: '',
      mediaID: null,
      mediaObject: null
    });

    setAttributes({ items: newItems });
  }
};
```

### removeItem
Function that removes an item from the array based on its index.

```jsx
const removeItem = index => {
  if (items) {
    let newItems = [...items];

    newItems = newItems.filter((curr, i) => {
      return i !== index;
    });

    setAttributes({ items: newItems });
  }
};
```

### updateField
Used to update array item data within the array.

```jsx
const updateField = (index, field, value) => {
  const newItems = [...items];
  newItems[index][field] = value;

  setAttributes({ items: newItems });
};
```
