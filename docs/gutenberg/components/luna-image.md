# LunaImage
Image components that adds custom images to blocks.

## Props

### label
- Type: `String`
- Required: No

### size
- Type: `String`
- Required: No
- Default: 'large'

### mediaID
Media ID of our selected image.

- Type: `Number`
- Required: Yes

### image
Our image object.

- Type: `Object`
- Required: Yes

### className
Optional custom class name for the image wrapper and image.

- Type: `String`
- Required: No

### onImageSelect
Our image function to update the `mediaID` and `mediaObject` attributes on image select.

- Type: `Function`
- Required: Yes

### Usage
```javascript
registerBlockType('luna/blockname', {
	...
	attributes: {
    mediaID: {
      type: 'number'
    },
    mediaObject: {
      type: 'object'
    }
	},
  ...
});

// edit.js
<LunaImage
  size="medium"
  mediaID={ mediaID }
  image={ mediaObject }
  className="custom-class-name"
  onImageSelect={
    (imageObject, imageID) => setAttributes({
      mediaObject: imageObject,
      mediaID: imageID
    })
  }
/>

// edit.js / inspector.js
<LunaInspectorImage
  label={ __('Image') }
  size="medium"
  mediaID={ mediaID }
  image={ mediaObject }
  className="custom-class-name"
  onImageSelect={
    (imageObject, imageID) => setAttributes({
      mediaObject: imageObject,
      mediaID: imageID
    })
  }
/>

// save.js
<LunaImage.Content
  className="custom-class-name"
  image={ mediaObject }
/>
<LunaInspectorImage.Content
  className="custom-class-name"
  image={ mediaObject }
/>
```

### Output
```html
<figure class="custom-class-name">
  <picture>
    <source data-srcset="desktop.png" media="(min-width: 768px)" />
    <source data-srcset="tablet.png" media="(min-width: 375px)" />
    <img
      data-src="mobile.png"
      alt="alt for image"
      width="375"
      height="280"
      class="custom-class-name__image"
    />
  </picture>
</figure>
```