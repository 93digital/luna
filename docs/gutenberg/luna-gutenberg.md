# Luna Gutenberg development

We have two main methods of Gutenberg development. Standard block creation using the default WordPress scripts and ACF (Advanced Custom Fields) Blocks.

## Block creation

### Standard block creation
Standard block creation utilizing the `@wordpress` gutenberg packages like `registerBlockType`. See the [Block Editor Handbook](https://developer.wordpress.org/block-editor/developers/) for more information.

#### File structure
```
├── js/
│   ├── blocks/
│   │   ├── blocks/
│   │   │   └── m01-example/     // Single block directory.
│   │   │       ├── index.js     // Register block type.
│   │   │       ├── edit.js      // Edit function/output BackEnd.
│   │   │       ├── save.js      // Save function/output FrontEnd.
│   │   │       └── inspector.js // Sidebar functionality.
│   │   ├── blocks.js            // Import blocks here.
│   │   └── unregister-styles.js // Unregister default block styles.
```

### ACF blocks
ACF blocks use custom fields allowing developers more familiar with PHP development to hit the ground running. See [ACF Blocks](https://www.advancedcustomfields.com/resources/blocks/) for more information.

#### File structure
```
├── acf-blocks
│   └── m01-example.php // Block code for both  Front & BackEnd.
```
