# Luna Utilities

The `Luna_Utils` class sole purpose is to house utility functions which may be required throughout the theme. There is no `__construct()` so instantiation just makes the utility methods of this class (and it's parent) available via the `$luna->utils` object.

## Built-in utilities

A number of useful utility methods are inherited from the base class `Luna_Base_Utils`, which are detailed below.

### Filename to text

Converts a filename or filepath to a human readable string.

**Usage:**
```php
/**
 * @param string $filepath [required] The filepath to convert.
 *                         Can inclue directories and file extensions which will be removed.
 *
 * @return string A human readable string.
 */
$luna->utils->filename2text( $filepath );
```

### Get the primary taxonomy term

Returns a post's primary term within a given taxonomy. The primary term functionality is provided by Yoast and used when a post has more than one term of a certain taxonomy.

**Usage:**
```php
/**
 * @param int    $post_id  [required] ID of the post we need the primary term for.
 * @param string $taxonomy [required] Slug of the taxonomy to check.
 *
 * @return object A WP_Term object of the primary term.
 *                If the primary term has not been defined then the first term is returned.
 */
$luna->utils->get_the_primary_term( $post_id, $taxonomy );
```

### Get a YouTube ID from a URL

**Usage:**
```php
/**
 * @param string $youtube_url [required] A YouTube video URL.
 *
 * @return string|bool The YouTube ID or false on failure.
 */
$luna->utils->get_youtube_url( $youtube_url );
```

### Optimised image

Returns the markup for an image element which will work with the npm Lazyload package used byt the theme.

**Usage:**
```php
/**
 * @param int|string  $id_or_url   [required] The attachment ID or file URL for the image.
 * @param string      $size        [optional] A WordPress image size.
 * @param string|bool $size_retina [optional] A WordPress image size for retina screens.
 * @param string      $css_class   [optional] CSS class names for the <img> tag.
 * @param bool        $echo        [optional] Whether to output the resulting SVG markup.
 *
 * @return string $image_elem The image element markup.
 */
$luna->utils->image( $id_or_url, $size = 'large', $size_retina = false, $class = '', $echo = true )
```

### Check if a URL is from YouTube

**Usage:**
```php
/**
 * @param string $url [required] A URL to check.
 *
 * @return boolean Is the URL a YouTube URL?
 */
$luna->utils->is_youtube_url( $url );
```

### Array to HTML attributes

Convert an array into a string of HTML attributes.

**Usage:**
```php
/**
 * @param array $atts_array [required] An $atts => $val key value pair associative array.
 *
 * @return array A string of HTML attributes.
 */
$luna->utils->parse_atts_array( $atts_array );
```

**Example:**
```php
$atts = [
  'src'   => 'https://bit.ly/3rFcsWT',
  'class' => 'rr-image',
  'alt'   => 'Unexpected image',
];
echo '<img ' . $luna->utils->parse_atts_array( $atts ) . ' />';
```
Outputs as:
```html
<img src="https://bit.ly/3rFcsWT" class="rr-image" alt="Unexpected image" />
```

### Remove HTTP from URL

Strip the `http://` or `https://` from a URL.

**Usage:**
```php
/**
 * @param string $url [required] URL to strip.
 *
 * @return string A http stripped URL.
 */
$luna->utils->remove_http( $url );
```

### Search query summary

Output a summary of a search query displaying the current index of results on the page and the total number of reasults. This should only be used on a search or archive page as it checks the default `$wp_query` object.

**Usage:**
```php
/**
 * @param string $template [optional] The output template for the summary string.
 *                         Is is used with the PHP sprintf() built in function.
 *
 * @return void The result is echoed rather than returned.
 */
$luna->utils->search_query_summary( $template = 'Showing %1$s - %2$s of %3$s' );
```

### Strip URL parameters

```php
/**
 * @param string $url [required] URL to remove parameters from.
 *
 * @return string $url URL with parameters removed.
 */
$luna->utils->strip_url_parameters( $url );
```

### Generate SVG markup

Returns the markup for a custom SVG added to `/assets/svg`. Please ensure any strings are internationa

```php
/**
 * @param string $icon        [required] The icon filename (without the file extension).
 * @param string $title       [optional] SVG title for accessibility.
 * @param string $description [optional] SVG description for accessibility.
 * @param bool   $echo        [optional] Whether to echo the resulting SVG markup.
 *
 * @return string SVG markup.
 */
$luna->utils->svg( $icon, $title = '', $description = '', $echo = true );
```

### Truncate a string

Truncates a string text to a certian character length.

```php
/**
 * @param string $string [required] The string to truncate.
 * @param int    $length [optional] The character length of the truncated string.
 *
 * @return string $string Truncated string.
 */
$luna->utils->truncate_text( $string, $length = 100 );
```
