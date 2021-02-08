wp.domReady(() => {
  // Lists out all block styles.
  wp.blocks.getBlockTypes().forEach(block => {
    if (block.styles.isArray) {
      console.log(block.name, block.styles.map(obj => obj.name));
    }
  });

  // Unregister quote styles.
  wp.blocks.unregisterBlockStyle('core/quote', 'default');
  wp.blocks.unregisterBlockStyle('core/quote', 'large');

  // Unregister button styles.
  wp.blocks.unregisterBlockStyle('core/button', 'fill');
  wp.blocks.unregisterBlockStyle('core/button', 'outline');

  // Unregister image styles.
  wp.blocks.unregisterBlockStyle('core/image', 'default');
  wp.blocks.unregisterBlockStyle('core/image', 'rounded');

  // Unregister separator styles.
  wp.blocks.unregisterBlockStyle('core/separator', 'default');
  wp.blocks.unregisterBlockStyle('core/separator', 'wide');
  wp.blocks.unregisterBlockStyle('core/separator', 'dots');

  // Unregister table styles.
  wp.blocks.unregisterBlockStyle('core/table', 'regular');
  wp.blocks.unregisterBlockStyle('core/table', 'stripes');
});

