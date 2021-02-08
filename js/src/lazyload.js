/**
 * LazyLoad
 * Defers the loading of 'below-the-fold' images, videos and iframes.
 *
 * Usage:
 * See official docs https://github.com/verlok/lazyload
 *
 * Basic Example:
 * <img class="lazy" data-src="https://via.placeholder.com/150" alt="">
 * <div class="lazy" data-bg="https://via.placeholder.com/150"></div>
 */
import LazyLoad from 'vanilla-lazyload';

(() => {
  luna.lazyLoadInstance = new LazyLoad({ // eslint-disable-line
    elements_selector: '.lazy'
  });
})();
