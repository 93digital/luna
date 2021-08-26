wp.domReady(() => {
  // Lists out all block styles in editor console.
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

  // Unregister block types.
  wp.blocks.unregisterBlockType('core/gallery');
  wp.blocks.unregisterBlockType('core/shortcode');
  wp.blocks.unregisterBlockType('core/archives');
  wp.blocks.unregisterBlockType('core/audio');
  wp.blocks.unregisterBlockType('core/buttons');
  wp.blocks.unregisterBlockType('core/button');
  wp.blocks.unregisterBlockType('core/calendar');
  wp.blocks.unregisterBlockType('core/categories');
  wp.blocks.unregisterBlockType('core/cover');
  wp.blocks.unregisterBlockType('core/code');
  wp.blocks.unregisterBlockType('core/file');
  wp.blocks.unregisterBlockType('core/media-text');
  wp.blocks.unregisterBlockType('core/latest-comments');
  wp.blocks.unregisterBlockType('core/latest-posts');
  wp.blocks.unregisterBlockType('core/missing');
  wp.blocks.unregisterBlockType('core/more');
  wp.blocks.unregisterBlockType('core/nextpage');
  wp.blocks.unregisterBlockType('core/page-list');
  wp.blocks.unregisterBlockType('core/preformatted');
  wp.blocks.unregisterBlockType('core/pullquote');
  wp.blocks.unregisterBlockType('core/rss');
  wp.blocks.unregisterBlockType('core/search');
  wp.blocks.unregisterBlockType('core/social-links');
  wp.blocks.unregisterBlockType('core/social-link');
  wp.blocks.unregisterBlockType('core/table');
  wp.blocks.unregisterBlockType('core/tag-cloud');
  wp.blocks.unregisterBlockType('core/text-columns');
  wp.blocks.unregisterBlockType('core/verse');
  wp.blocks.unregisterBlockType('core/video');
  wp.blocks.unregisterBlockType('core/site-logo');
  wp.blocks.unregisterBlockType('core/site-tagline');
  wp.blocks.unregisterBlockType('core/site-title');
  wp.blocks.unregisterBlockType('core/query');
  wp.blocks.unregisterBlockType('core/post-template');
  wp.blocks.unregisterBlockType('core/query-title');
  wp.blocks.unregisterBlockType('core/query-pagination');
  wp.blocks.unregisterBlockType('core/query-pagination-next');
  wp.blocks.unregisterBlockType('core/query-pagination-numbers');
  wp.blocks.unregisterBlockType('core/query-pagination-previous');
  wp.blocks.unregisterBlockType('core/post-title');
  wp.blocks.unregisterBlockType('core/post-content');
  wp.blocks.unregisterBlockType('core/post-date');
  wp.blocks.unregisterBlockType('core/post-excerpt');
  wp.blocks.unregisterBlockType('core/post-featured-image');
  wp.blocks.unregisterBlockType('core/post-terms');
  wp.blocks.unregisterBlockType('core/loginout');

  // Unregister Embeds.
  wp.blocks.unregisterBlockVariation('core/embed', 'amazon-kindle');
  wp.blocks.unregisterBlockVariation('core/embed', 'animoto');
  wp.blocks.unregisterBlockVariation('core/embed', 'cloudup');
  wp.blocks.unregisterBlockVariation('core/embed', 'collegehumor');
  wp.blocks.unregisterBlockVariation('core/embed', 'crowdsignal');
  wp.blocks.unregisterBlockVariation('core/embed', 'dailymotion');
  wp.blocks.unregisterBlockVariation('core/embed', 'flickr');
  wp.blocks.unregisterBlockVariation('core/embed', 'imgur');
  wp.blocks.unregisterBlockVariation('core/embed', 'instagram');
  wp.blocks.unregisterBlockVariation('core/embed', 'issuu');
  wp.blocks.unregisterBlockVariation('core/embed', 'kickstarter');
  wp.blocks.unregisterBlockVariation('core/embed', 'meetup-com');
  wp.blocks.unregisterBlockVariation('core/embed', 'mixcloud');
  wp.blocks.unregisterBlockVariation('core/embed', 'reddit');
  wp.blocks.unregisterBlockVariation('core/embed', 'reverbnation');
  wp.blocks.unregisterBlockVariation('core/embed', 'screencast');
  wp.blocks.unregisterBlockVariation('core/embed', 'scribd');
  wp.blocks.unregisterBlockVariation('core/embed', 'slideshare');
  wp.blocks.unregisterBlockVariation('core/embed', 'smugmug');
  wp.blocks.unregisterBlockVariation('core/embed', 'soundcloud');
  wp.blocks.unregisterBlockVariation('core/embed', 'speaker-deck');
  wp.blocks.unregisterBlockVariation('core/embed', 'spotify');
  wp.blocks.unregisterBlockVariation('core/embed', 'ted');
  wp.blocks.unregisterBlockVariation('core/embed', 'tiktok');
  wp.blocks.unregisterBlockVariation('core/embed', 'tumblr');
  wp.blocks.unregisterBlockVariation('core/embed', 'videopress');
  wp.blocks.unregisterBlockVariation('core/embed', 'vimeo');
  wp.blocks.unregisterBlockVariation('core/embed', 'wordpress');
  wp.blocks.unregisterBlockVariation('core/embed', 'wordpress-tv');
  wp.blocks.unregisterBlockVariation('core/embed', 'youtube');
});

